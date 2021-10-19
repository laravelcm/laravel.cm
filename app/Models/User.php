<?php

namespace App\Models;

use App\Traits\HasProfilePhoto;
use App\Traits\Reacts;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use InteractsWithMedia,
        HasFactory,
        Notifiable,
        HasProfilePhoto,
        HasRoles,
        Reacts;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
        'bio',
        'location',
        'avatar',
        'avatar_type',
        'phone_number',
        'github_profile',
        'twitter_profile',
        'website',
        'last_login_at',
        'last_login_ip',
        'email_verified_at',
        'opt_in',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'settings' => 'array',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function hasProvider($provider): bool
    {
        foreach ($this->providers as $p) {
            if ($p->provider == $provider) {
                return true;
            }
        }

        return false;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isModerator(): bool
    {
        return $this->hasRole('moderator');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatar')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png']);
    }

    public static function findByUsername(string $username): self
    {
        return static::where('username', $username)->firstOrFail();
    }

    public static function findByEmailAddress(string $emailAddress): self
    {
        return static::where('email', $emailAddress)->firstOrFail();
    }

    public static function findOrCreateSocialUserProvider($socialUser, string $provider): self
    {
        $socialEmail = $socialUser->email ?? "{$socialUser->id}@{$provider}.com";

        $user = static::where('email', $socialEmail)->first();

        if (! $user) {
            $user = self::create([
                'name' => $socialUser->getName(),
                'email' => $socialEmail,
                'username' => $socialUser->getNickName() ?? $socialUser->getId(),
                'github_profile' => $provider === 'github' ? $socialUser->getNickName() : null,
                'twitter_profile' => $provider === 'twitter' ? $socialUser->getNickName() : null,
                'email_verified_at' => now(),
                'avatar_type' => $provider,
            ]);
        }

        return $user;
    }

    public function providers(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    public function latestArticles(int $amount = 10)
    {
        return $this->articles()->latest()->limit($amount)->get();
    }

    public function countArticles(): int
    {
        return $this->articles()->count();
    }

    public function githubUsername(): string
    {
        return $this->github_profile ?? '';
    }

    public function twitter(): ?string
    {
        return $this->twitter_profile;
    }

    /**
     * Retrieve a setting with a given name or fall back to the default.
     */
    public function setting(string $name, $default = null)
    {
        if ($this->settings && array_key_exists($name, $this->settings)) {
            return $this->settings[$name];
        }

        return $default;
    }

    /**
     * Update one or more settings and then optionally save the model.
     */
    public function settings(array $revisions, bool $save = true): self
    {
        $this->settings = array_merge($this->settings ?? [], $revisions);

        if ($save) {
            $this->save();
        }

        return $this;
    }

    public function hasPassword(): bool
    {
        $password = $this->getAuthPassword();

        return $password !== '' && $password !== null;
    }
}
