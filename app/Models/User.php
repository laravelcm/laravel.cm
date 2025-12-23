<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\HasCachedMediaInterface;
use App\Enums\TransactionStatus;
use App\Observers\UserObserver;
use App\Traits\HasProfilePhoto;
use App\Traits\HasSettings;
use App\Traits\HasUsername;
use App\Traits\Reacts;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
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
 * @property-read string $name
 * @property-read string $email
 * @property-read string $username
 * @property-read string $avatar_type
 * @property-read string $profile_photo_url
 * @property-read string|null $location
 * @property-read string|null $phone_number
 * @property-read string|null $github_profile
 * @property-read string|null $twitter_profile
 * @property-read string|null $linkedin_profile
 * @property-read string|null $bio
 * @property-read string|null $website
 * @property-read string|null $banned_reason
 * @property-read array<array-key, mixed>|null $settings
 * @property-read Carbon|null $email_verified_at
 * @property-read Carbon|null $last_login_at
 * @property-read Carbon|null $banned_at
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * @property-read Carbon|null $last_active_at
 * @property-read \Illuminate\Support\Collection<array-key, Activity> $activities
 * @property-read \Illuminate\Support\Collection<array-key, Article> $articles
 * @property-read \Illuminate\Support\Collection<array-key, Thread> $threads
 * @property-read \Illuminate\Support\Collection<array-key, Discussion> $discussions
 * @property-read \Illuminate\Support\Collection<array-key, Subscribe> $subscriptions
 * @property-read \Illuminate\Support\Collection<array-key, SocialAccount> $providers
 * @property-read int $discussions_count
 */
#[ObservedBy(UserObserver::class)]
final class User extends Authenticatable implements FilamentUser, HasAvatar, HasCachedMediaInterface, HasMedia, HasName, MustVerifyEmail
{
    use Gamify;

    /** @use HasFactory<UserFactory> */
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

    protected function rolesLabel(): Attribute
    {
        $roles = $this->getRoleNames()->toArray();

        return Attribute::get(
            fn (): string => count($roles) > 0
                ? implode(', ', array_map(fn ($item): string => ucwords($item), $roles))
                : 'N/A'
        );
    }

    protected function IsSponsor(): Attribute
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

    public function hasProvider(string $provider): bool
    {
        return $this->providers->contains(fn ($p): bool => $p->provider === $provider);
    }

    public function hasEnterprise(): bool
    {
        return $this->enterprise !== null;
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

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@laravel.cm') || $this->isModerator() || $this->isAdmin();
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function getFilamentAvatarUrl(): string
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
            ->acceptsMimeTypes([
                'image/jpg',
                'image/jpeg',
                'image/png',
                'image/gif',
            ]);
    }

    public static function findByEmailAddress(string $emailAddress): self
    {
        return self::query()->where('email', $emailAddress)->firstOrFail();
    }

    public static function findOrCreateSocialUserProvider(SocialUser $socialUser, string $provider, string $role = 'user'): self
    {
        $socialEmail = $socialUser->getEmail() ?? "{$socialUser->getId()}@{$provider}.com";

        $user = self::query()->where('email', $socialEmail)->first();

        if (! $user instanceof self) {
            $user = self::query()->create([
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
        return filled($this->twitter());
    }

    public function linkedin(): ?string
    {
        return $this->linkedin_profile;
    }

    public function hasPassword(): bool
    {
        $password = $this->getAuthPassword();

        return filled($password) || $password !== null; // @phpstan-ignore-line
    }

    public function delete(): ?bool
    {
        $this->deleteThreads();
        $this->deleteReplies();

        return parent::delete();
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
        return $this->replyAble()->isSolution()->count();
    }

    public function countArticles(): int
    {
        return $this->articles()->approved()->count();
    }

    public function countDiscussions(): int
    {
        return $this->discussions()->count();
    }

    public function countThreads(): int
    {
        return $this->threads()->count();
    }

    public function banned(): bool
    {
        return $this->banned_at !== null;
    }

    public function notBanned(): bool
    {
        return ! $this->banned();
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function hasActivity(Builder $query): Builder
    {
        return $query->where(function ($query): void {
            $query->has('threads')
                ->orHas('replyAble');
        });
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function moderators(Builder $query): Builder
    {
        return $query->whereHas('roles', function ($query): void {
            $query->where('name', '<>', 'user');
        });
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function withoutRole(Builder $query): Builder
    {
        return $query->whereDoesntHave('roles');
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function verifiedUsers(Builder $query): Builder
    {
        return $query->whereNotNull('email_verified_at');
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function unVerifiedUsers(Builder $query): Builder
    {
        return $query->whereNull('email_verified_at');
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function mostSolutions(Builder $query, ?int $inLastDays = null): Builder
    {
        return $query->withCount(['replyAble as solutions_count' => function ($query) use ($inLastDays) {
            $query->where('replyable_type', 'thread')
                ->join('threads', 'threads.solution_reply_id', '=', 'replies.id');

            if (filled($inLastDays)) {
                $query->where('replies.created_at', '>', now()->subDays($inLastDays));
            }

            return $query;
        }])->orderBy('solutions_count', 'desc');
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function mostSubmissions(Builder $query, ?int $inLastDays = null): Builder
    {
        return $query->withCount(['articles as articles_count' => function ($query) use ($inLastDays) {
            if (filled($inLastDays)) {
                $query->where('articles.approved_at', '>', now()->subDays($inLastDays));
            }

            return $query;
        }])->orderByDesc('articles_count');
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function mostSolutionsInLastDays(Builder $query, int $days): Builder
    {
        return $query->mostSolutions($days);
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function mostSubmissionsInLastDays(Builder $query, int $days): Builder
    {
        return $query->mostSubmissions($days);
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function withCounts(Builder $query): Builder
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
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function topContributors(Builder $query): Builder
    {
        return $query->withCount('discussions')->orderByDesc('discussions_count');
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function isBanned(Builder $query): Builder
    {
        return $query->whereNotNull('banned_at');
    }

    /**
     * @param  Builder<User>  $query
     * @return Builder<User>
     */
    #[Scope]
    protected function isNotBanned(Builder $query): Builder
    {
        return $query->whereNull('banned_at');
    }

    /**
     * @return HasOne<Enterprise, $this>
     */
    public function enterprise(): HasOne
    {
        return $this->hasOne(Enterprise::class);
    }

    /**
     * @return HasMany<SocialAccount, $this>
     */
    public function providers(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * @return HasMany<Article, $this>
     */
    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    /**
     * @return HasMany<Activity, $this>
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * @return HasMany<Thread, $this>
     */
    public function threads(): HasMany
    {
        return $this->hasMany(Thread::class);
    }

    /**
     * @return HasMany<Reply, $this>
     */
    public function replyAble(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * @return HasMany<Discussion, $this>
     */
    public function discussions(): HasMany
    {
        return $this->hasMany(Discussion::class);
    }

    /**
     * @return HasMany<Subscribe, $this>
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscribe::class);
    }

    /**
     * @return HasMany<Transaction, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * @return HasMany<SpamReport, $this>
     */
    public function spamReports(): HasMany
    {
        return $this->hasMany(SpamReport::class, 'user_id');
    }
}
