<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Discussion;
use App\Models\Reply;
use App\Models\Thread;
use App\Policies\ArticlePolicy;
use App\Policies\DiscussionPolicy;
use App\Policies\NotificationPolicy;
use App\Policies\ReplyPolicy;
use App\Policies\ThreadPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Notifications\DatabaseNotification as Notification;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Article::class => ArticlePolicy::class,
        Thread::class => ThreadPolicy::class,
        Reply::class => ReplyPolicy::class,
        Discussion::class => DiscussionPolicy::class,
        Notification::class => NotificationPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function ($user, string $token) {
            return config('lcm.spa_url').'/auth/password/reset?token='.$token;
        });

        Gate::before(function ($user) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}
