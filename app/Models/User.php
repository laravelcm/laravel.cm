<?php

namespace App\Models;

use App\Traits\HasProfilePhoto;
use App\Traits\Reacts;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use HasFactory,
        HasProfilePhoto,
        HasRoles,
        InteractsWithMedia,
        Notifiable,
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
        'linkedin_profile',
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

    public function isLoggedInUser(): bool
    {
        return $this->id === Auth::id();
    }

    public function profile(): array
    {
        return [
            'name' => $this->name,
            'username' => $this->username,
            'picture' => $this->profile_photo_url,
        ];
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

            $user->assignRole('user');
        }

        return $user;
    }

    public function providers(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    public function replyAble(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }

    public function deleteThreads()
    {
        // We need to explicitly iterate over the threads and delete them
        // separately because all related models need to be deleted.
        foreach ($this->threads as $thread) {
            $thread->delete();
        }
    }

    public function deleteReplies()
    {
        // We need to explicitly iterate over the replies and delete them
        // separately because all related models need to be deleted.
        foreach ($this->replyAble->get() as $reply) {
            $reply->delete();
        }
    }

    public function latestArticles(int $amount = 10): Collection
    {
        return $this->articles()->latest()->limit($amount)->get();
    }

    public function githubUsername(): ?string
    {
        return $this->github_profile;
    }

    public function twitter(): ?string
    {
        return $this->twitter_profile;
    }

    public function linkedin(): ?string
    {
        return $this->linkedin_profile;
    }

    public function scopeModerators(Builder $query): Builder
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', '<>', 'user');
        });
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

    public function delete()
    {
        $this->deleteThreads();
        $this->deleteReplies();

        parent::delete();
    }

    public function scopeHasActivity(Builder $query)
    {
        return $query->where(function ($query) {
            $query->has('threads')
                ->orHas('replyAble');
        });
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack($notification): string
    {
        return env('SLACK_WEBHOOK_URL', '');
    }

    public function replies(): Collection
    {
        return $this->replyAble;
    }

    public function countReplies(): int
    {
        return Cache::remember('replies_count', now()->addHours(2), fn () => $this->replyAble()->count());
    }

    public function countSolutions(): int
    {
        return Cache::remember('solutions_count', now()->addHours(2), fn () => $this->replyAble()->isSolution()->count());
    }

    public function countArticles(): int
    {
        return Cache::remember('articles_count', now()->addHours(2), fn () => $this->articles()->approved()->count());
    }

    public function countDiscussions(): int
    {
        return Cache::remember('discussions_count', now()->addHours(2), fn () => $this->discussions()->count());
    }

    public function countThreads(): int
    {
        return Cache::remember('threads_count', now()->addHours(2), fn () => $this->threads()->count());
    }

    public function scopeMostSolutions(Builder $query, int $inLastDays = null)
    {
        return $query->withCount(['replyAble as solutions_count' => function ($query) use ($inLastDays) {
            $query->where('replyable_type', 'threads')
                ->join('threads', 'threads.solution_reply_id', '=', 'replies.id');

            if ($inLastDays) {
                $query->where('replies.created_at', '>', now()->subDays($inLastDays));
            }

            return $query;
        }])->orderBy('solutions_count', 'desc');
    }

    public function scopeMostSubmissions(Builder $query, int $inLastDays = null)
    {
        return $query->withCount(['articles as articles_count' => function ($query) use ($inLastDays) {
            if ($inLastDays) {
                $query->where('articles.approved_at', '>', now()->subDays($inLastDays));
            }

            return $query;
        }])->orderByDesc('articles_count');
    }

    public function scopeMostSolutionsInLastDays(Builder $query, int $days)
    {
        return $query->mostSolutions($days);
    }

    public function scopeMostSubmissionsInLastDays(Builder $query, int $days)
    {
        return $query->mostSubmissions($days);
    }

    public function scopeWithCounts(Builder $query)
    {
        return $query->withCount([
            'articles as articles_count',
            'threads as threads_count',
            'replyAble as replies_count',
            'replyAble as solutions_count' => function (Builder $query) {
                return $query->join('threads', 'threads.solution_reply_id', '=', 'replies.id')
                    ->where('replyable_type', Thread::class);
            },
        ]);
    }

    public function scopeTopContributors(Builder $query): Builder
    {
        return $query->withCount(['discussions'])->orderByDesc('discussions_count');
    }
}
