<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TransactionStatus;
use App\Observers\UserObserver;
use App\Traits\HasProfilePhoto;
use App\Traits\HasSettings;
use App\Traits\HasUsername;
use App\Traits\Reacts;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Contracts\User as SocialUser;
use Laravelcm\Gamify\Traits\Gamify;
use Laravelcm\Subscriptions\Traits\HasPlanSubscriptions;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property string $username
 * @property string $avatar_type
 * @property string $profile_photo_url
 * @property string | null $location
 * @property string | null $phone_number
 * @property string | null $github_profile
 * @property string | null $twitter_profile
 * @property string | null $linkedin_profile
 * @property string | null $bio
 * @property string | null $website
 * @property string | null $banned_reason
 * @property array $settings
 * @property Carbon | null $email_verified_at
 * @property Carbon | null $last_login_at
 * @property Carbon | null $banned_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon | null $last_active_at
 * @property Collection | Activity[] $activities
 * @property Collection | Article[] $articles
 * @property Collection | Thread[] $threads
 * @property Collection | Discussion[] $discussions
 * @property Collection | Subscribe[] $subscriptions
 * @property-read Collection | SocialAccount[] $providers
 */
#[ObservedBy(UserObserver::class)]
final class User extends Authenticatable implements FilamentUser, HasAvatar, HasMedia, HasName, MustVerifyEmail
{
    use Gamify;
    use HasFactory;
    use HasPlanSubscriptions;
    use HasProfilePhoto;
    use HasRoles;
    use HasSettings;
    use HasUsername;
    use InteractsWithMedia;
    use Notifiable;
    use Reacts;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'last_active_at',
    ];

    protected $with = [
        'providers',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'banned_at' => 'datetime',
            'settings' => 'array',
            'last_active_at' => 'datetime',
        ];
    }

    public function hasProvider(string $provider): bool
    {
        foreach ($this->providers as $p) {
            if ($p->provider === $provider) {
                return true;
            }
        }

        return false;
    }

    public function hasEnterprise(): bool
    {
        return $this->enterprise !== null;
    }

    public function rolesLabel(): Attribute
    {
        $roles = $this->getRoleNames()->toArray();

        return Attribute::get(
            fn () => count($roles)
            ? implode(', ', array_map(fn ($item) => ucwords($item), $roles))
            : 'N/A'
        );
    }

    public function IsSponsor(): Attribute
    {
        return Attribute::get(function (): bool {
            if ($this->transactions_count > 0) {
                $transaction = $this->transactions()
                    ->where('status', TransactionStatus::COMPLETE->value)
                    ->first();

                return (bool) $transaction;
            }

            return false;
        });
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isModerator(): bool
    {
        return $this->hasRole('moderator');
    }

    public function isEnterprise(): bool
    {
        return $this->hasRole('company');
    }

    public function isLoggedInUser(): bool
    {
        return $this->id === Auth::id();
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return str_ends_with($this->email, '@laravel.cm') || $this->isModerator() || $this->isAdmin();
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile_photo_url;
    }

    /**
     * @return array{name: string, username: string, picture: string|null}
     */
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
            ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/gif']);
    }

    public static function findByEmailAddress(string $emailAddress): self
    {
        return self::where('email', $emailAddress)->firstOrFail();
    }

    public static function findOrCreateSocialUserProvider(SocialUser $socialUser, string $provider, string $role = 'user'): self
    {
        $socialEmail = $socialUser->getEmail() ?? "{$socialUser->getId()}@{$provider}.com";

        $user = self::where('email', $socialEmail)->first();

        if (! $user) {
            $user = self::create([
                'name' => $socialUser->getName() ?? $socialUser->getNickName() ?? $socialUser->getId(),
                'email' => $socialEmail,
                'username' => $socialUser->getNickName() ?? $socialUser->getId(),
                'github_profile' => $provider === 'github' ? $socialUser->getNickName() : null,
                'twitter_profile' => $provider === 'twitter' ? $socialUser->getNickName() : null,
                'email_verified_at' => now(),
                'avatar_type' => $provider,
            ]);

            $user->assignRole($role);
        }

        return $user;
    }

    public function enterprise(): HasOne
    {
        return $this->hasOne(Enterprise::class);
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

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscribe::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function spamReports(): HasMany
    {
        return $this->hasMany(SpamReport::class, 'user_id');
    }

    public function deleteThreads(): void
    {
        // We need to explicitly iterate over the threads and delete them
        // separately because all related models need to be deleted.
        foreach ($this->threads as $thread) {
            $thread->delete();
        }
    }

    public function deleteReplies(): void
    {
        // We need to explicitly iterate over the replies and delete them
        // separately because all related models need to be deleted.
        foreach ($this->replyAble->all() as $reply) {
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

    public function hasTwitterAccount(): bool
    {
        return ! empty($this->twitter());
    }

    public function linkedin(): ?string
    {
        return $this->linkedin_profile;
    }

    public function scopeModerators(Builder $query): Builder
    {
        return $query->whereHas('roles', function ($query): void {
            $query->where('name', '<>', 'user');
        });
    }

    public function scopeWithoutRole(Builder $query): Builder
    {
        return $query->whereDoesntHave('roles');
    }

    public function scopeVerifiedUsers(Builder $query): Builder
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeUnVerifiedUsers(Builder $query): Builder
    {
        return $query->whereNull('email_verified_at');
    }

    public function hasPassword(): bool
    {
        $password = $this->getAuthPassword();

        return ! empty($password) || $password !== null; // @phpstan-ignore-line
    }

    public function delete(): ?bool
    {
        $this->deleteThreads();
        $this->deleteReplies();

        return parent::delete();
    }

    public function scopeHasActivity(Builder $query): Builder
    {
        return $query->where(function ($query): void {
            $query->has('threads')
                ->orHas('replyAble');
        });
    }

    public function replies(): Collection
    {
        return $this->replyAble;
    }

    public function countReplies(): int
    {
        return $this->replyAble()->count();
    }

    public function countSolutions(): int
    {
        return $this->replyAble()->isSolution()->count(); // @phpstan-ignore-line
    }

    public function countArticles(): int
    {
        return $this->articles()->approved()->count(); // @phpstan-ignore-line
    }

    public function countDiscussions(): int
    {
        return $this->discussions()->count();
    }

    public function countThreads(): int
    {
        return $this->threads()->count();
    }

    public function scopeMostSolutions(Builder $query, ?int $inLastDays = null): Builder
    {
        return $query->withCount(['replyAble as solutions_count' => function ($query) use ($inLastDays) {
            $query->where('replyable_type', 'thread')
                ->join('threads', 'threads.solution_reply_id', '=', 'replies.id');

            if ($inLastDays) {
                $query->where('replies.created_at', '>', now()->subDays($inLastDays));
            }

            return $query;
        }])->orderBy('solutions_count', 'desc');
    }

    public function scopeMostSubmissions(Builder $query, ?int $inLastDays = null): Builder
    {
        return $query->withCount(['articles as articles_count' => function ($query) use ($inLastDays) {
            if ($inLastDays) {
                $query->where('articles.approved_at', '>', now()->subDays($inLastDays));
            }

            return $query;
        }])->orderByDesc('articles_count');
    }

    /**
     * Scope of most solutions in last days
     *
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeMostSolutionsInLastDays(Builder $query, int $days): Builder
    {
        return $query->mostSolutions($days);
    }

    /**
     * Scope for most submissions in the last days.
     *
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeMostSubmissionsInLastDays(Builder $query, int $days): Builder
    {
        return $query->mostSubmissions($days);
    }

    /**
     * Scope for all count values associate with a user.
     *
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeWithCounts(Builder $query): Builder
    {
        return $query->withCount([
            'discussions as discussions_count',
            'articles as articles_count',
            'threads as threads_count',
            'replyAble as replies_count',
            'replyAble as solutions_count' => fn (Builder $query) => $query->join('threads', 'threads.solution_reply_id', '=', 'replies.id')
                ->where('replyable_type', 'thread'),
        ]);
    }

    /**
     * Scope to get the top contributors on discussions.
     *
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeTopContributors(Builder $query): Builder
    {
        return $query->withCount(['discussions'])->orderByDesc('discussions_count');
    }

    /**
     * Get the banned user.
     *
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeIsBanned(Builder $query): Builder
    {
        return $query->whereNotNull('banned_at');
    }

    /**
     * Get the unbanned user.
     *
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    public function scopeIsNotBanned(Builder $query): Builder
    {
        return $query->whereNull('banned_at');
    }

    public function isBanned(): bool
    {
        return $this->banned_at !== null;
    }

    public function isNotBanned(): bool
    {
        return ! $this->isBanned();
    }
}
