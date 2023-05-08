<?php

declare(strict_types=1);

namespace App\Providers;

use App\Events\ApiRegistered;
use App\Events\ArticleWasSubmittedForApproval;
use App\Events\CommentWasAdded;
use App\Events\ReplyWasCreated;
use App\Events\SponsoringPaymentInitialize;
use App\Events\ThreadWasCreated;
use App\Listeners\NotifyMentionedUsers;
use App\Listeners\PostNewThreadNotification;
use App\Listeners\SendCompanyEmailVerificationNotification;
use App\Listeners\SendNewArticleNotification;
use App\Listeners\SendNewCommentNotification;
use App\Listeners\SendNewReplyNotification;
use App\Listeners\SendNewThreadNotification;
use App\Listeners\SendPaymentNotification;
use App\Listeners\SendWelcomeCompanyNotification;
use App\Listeners\SendWelcomeMailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

final class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array<string, array<int, string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendWelcomeMailNotification::class,
        ],
        ReplyWasCreated::class => [
            SendNewReplyNotification::class,
            NotifyMentionedUsers::class,
        ],
        ThreadWasCreated::class => [
            SendNewThreadNotification::class,
            PostNewThreadNotification::class,
        ],
        ArticleWasSubmittedForApproval::class => [
            SendNewArticleNotification::class,
        ],
        CommentWasAdded::class => [
            SendNewCommentNotification::class,
        ],
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            \SocialiteProviders\Twitter\TwitterExtendSocialite::class.'@handle',
        ],

        ApiRegistered::class => [
            SendCompanyEmailVerificationNotification::class,
            SendWelcomeCompanyNotification::class,
        ],

        SponsoringPaymentInitialize::class => [
            SendPaymentNotification::class,
        ],
    ];
}
