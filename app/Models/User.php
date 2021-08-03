<?php

namespace App\Models;

use App\Traits\HasProfilePhoto;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasProfilePhoto;

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
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function providers(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function hasProvider($provider): bool
    {
        foreach ($this->providers as $p) {
            if ($p->provider == $provider) {
                return true;
            }
        }

        return false;
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
}
