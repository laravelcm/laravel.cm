<?php

declare(strict_types=1);

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

namespace App\Models{
    /**
     * App\Models\Activity
     *
     * @property int $id
     * @property string $subject_type
     * @property int $subject_id
     * @property string $type
     * @property array|null $data
     * @property int $user_id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $subject
     * @property-read \App\Models\User $user
     * @method static \Database\Factories\ActivityFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereData($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereSubjectId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereSubjectType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereUserId($value)
     * @mixin \Eloquent
     */
    final class IdeHelperActivity
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Article
     *
     * @property int $id
     * @property string $title
     * @property string $body
     * @property string $slug
     * @property string|null $canonical_url
     * @property bool $show_toc
     * @property bool $is_pinned
     * @property int $is_sponsored
     * @property int|null $tweet_id
     * @property int $user_id
     * @property \Illuminate\Support\Carbon|null $published_at
     * @property \Illuminate\Support\Carbon|null $submitted_at
     * @property \Illuminate\Support\Carbon|null $approved_at
     * @property \Illuminate\Support\Carbon|null $shared_at
     * @property \Illuminate\Support\Carbon|null $declined_at
     * @property \Illuminate\Support\Carbon|null $sponsored_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Activity> $activity
     * @property-read int|null $activity_count
     * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
     * @property-read int|null $media_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reaction> $reactions
     * @property-read int|null $reactions_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
     * @property-read int|null $tags_count
     * @property-read \App\Models\User $user
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \CyrildeWit\EloquentViewable\View> $views
     * @property-read int|null $views_count
     * @method static \Illuminate\Database\Eloquent\Builder|Article approved()
     * @method static \Illuminate\Database\Eloquent\Builder|Article awaitingApproval()
     * @method static \Illuminate\Database\Eloquent\Builder|Article declined()
     * @method static \Database\Factories\ArticleFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder|Article forTag(string $tag)
     * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Article notApproved()
     * @method static \Illuminate\Database\Eloquent\Builder|Article notDeclined()
     * @method static \Illuminate\Database\Eloquent\Builder|Article notPinned()
     * @method static \Illuminate\Database\Eloquent\Builder|Article notPublished()
     * @method static \Illuminate\Database\Eloquent\Builder|Article notShared()
     * @method static \Illuminate\Database\Eloquent\Builder|Article orderByUniqueViews(string $direction = 'desc', $period = null, ?string $collection = null, string $as = 'unique_views_count')
     * @method static \Illuminate\Database\Eloquent\Builder|Article orderByViews(string $direction = 'desc', ?\CyrildeWit\EloquentViewable\Support\Period $period = null, ?string $collection = null, bool $unique = false, string $as = 'views_count')
     * @method static \Illuminate\Database\Eloquent\Builder|Article pinned()
     * @method static \Illuminate\Database\Eloquent\Builder|Article popular()
     * @method static \Illuminate\Database\Eloquent\Builder|Article published()
     * @method static \Illuminate\Database\Eloquent\Builder|Article query()
     * @method static \Illuminate\Database\Eloquent\Builder|Article recent()
     * @method static \Illuminate\Database\Eloquent\Builder|Article shared()
     * @method static \Illuminate\Database\Eloquent\Builder|Article sponsored()
     * @method static \Illuminate\Database\Eloquent\Builder|Article submitted()
     * @method static \Illuminate\Database\Eloquent\Builder|Article trending()
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereApprovedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereBody($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereCanonicalUrl($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereDeclinedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereIsPinned($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereIsSponsored($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article wherePublishedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereSharedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereShowToc($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereSponsoredAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereSubmittedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereTweetId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article whereUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Article withViewsCount(?\CyrildeWit\EloquentViewable\Support\Period $period = null, ?string $collection = null, bool $unique = false, string $as = 'views_count')
     * @mixin \Eloquent
     */
    final class IdeHelperArticle
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Channel
     *
     * @property int $id
     * @property string $name
     * @property string $slug
     * @property int|null $parent_id
     * @property string|null $color
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection<int, Channel> $items
     * @property-read int|null $items_count
     * @property-read Channel|null $parent
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Thread> $threads
     * @property-read int|null $threads_count
     * @method static \Database\Factories\ChannelFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder|Channel newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Channel newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Channel query()
     * @method static \Illuminate\Database\Eloquent\Builder|Channel whereColor($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Channel whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Channel whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Channel whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Channel whereParentId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Channel whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Channel whereUpdatedAt($value)
     * @mixin \Eloquent
     */
    final class IdeHelperChannel
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Discussion
     *
     * @property int $id
     * @property int $user_id
     * @property string $title
     * @property string $slug
     * @property string $body
     * @property bool $is_pinned
     * @property bool $locked
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Activity> $activity
     * @property-read int|null $activity_count
     * @property-read int $count_all_replies_with_child
     * @property-read \App\Models\Reply|null $latestReply
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reaction> $reactions
     * @property-read int|null $reactions_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reply> $replies
     * @property-read int|null $replies_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscribe> $subscribes
     * @property-read int|null $subscribes_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
     * @property-read int|null $tags_count
     * @property-read \App\Models\User $user
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \CyrildeWit\EloquentViewable\View> $views
     * @property-read int|null $views_count
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion active()
     * @method static \Database\Factories\DiscussionFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion forTag(string $tag)
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion noComments()
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion notPinned()
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion orderByUniqueViews(string $direction = 'desc', $period = null, ?string $collection = null, string $as = 'unique_views_count')
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion orderByViews(string $direction = 'desc', ?\CyrildeWit\EloquentViewable\Support\Period $period = null, ?string $collection = null, bool $unique = false, string $as = 'views_count')
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion pinned()
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion popular()
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion query()
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion recent()
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion whereBody($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion whereIsPinned($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion whereLocked($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion whereUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Discussion withViewsCount(?\CyrildeWit\EloquentViewable\Support\Period $period = null, ?string $collection = null, bool $unique = false, string $as = 'views_count')
     * @mixin \Eloquent
     */
    final class IdeHelperDiscussion
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Enterprise
     *
     * @property int $id
     * @property string $name
     * @property string $slug
     * @property string $website
     * @property string|null $address
     * @property string|null $description
     * @property string|null $about
     * @property string|null $founded_in
     * @property string|null $ceo
     * @property int $user_id
     * @property bool $is_certified
     * @property bool $is_featured
     * @property bool $is_public
     * @property string $size
     * @property array|null $settings
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
     * @property-read int|null $media_count
     * @property-read \App\Models\User $owner
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise certified()
     * @method static \Database\Factories\EnterpriseFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise featured()
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise filters(\Illuminate\Http\Request $request, array $filters = [])
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise public()
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise query()
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereAbout($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereAddress($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereCeo($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereFoundedIn($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereIsCertified($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereIsFeatured($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereIsPublic($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereSettings($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereSize($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Enterprise whereWebsite($value)
     * @mixin \Eloquent
     */
    final class IdeHelperEnterprise
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Feature
     *
     * @property int $id
     * @property string $name
     * @property int $is_enabled
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Feature newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Feature newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Feature query()
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereIsEnabled($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereUpdatedAt($value)
     * @mixin \Eloquent
     */
    final class IdeHelperFeature
    {
    }
}

namespace App\Models\Premium{
    /**
     * App\Models\Premium\Feature
     *
     * @property int $id
     * @property int $plan_id
     * @property string $slug
     * @property array $name
     * @property array|null $description
     * @property string $value
     * @property int $resettable_period
     * @property string $resettable_interval
     * @property int $sort_order
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property-read array $translations
     * @property-read \App\Models\Premium\Plan $plan
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Premium\SubscriptionUsage> $usage
     * @property-read int|null $usage_count
     * @method static \Illuminate\Database\Eloquent\Builder|PlanFeature byPlanId(int $planId)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Feature newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Feature onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|PlanFeature ordered(string $direction = 'asc')
     * @method static \Illuminate\Database\Eloquent\Builder|Feature query()
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature wherePlanId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereResettableInterval($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereResettablePeriod($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereSortOrder($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature whereValue($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Feature withTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Feature withoutTrashed()
     * @mixin \Eloquent
     */
    final class IdeHelperFeature
    {
    }
}

namespace App\Models\Premium{
    /**
     * App\Models\Premium\Plan
     *
     * @property int $id
     * @property string $slug
     * @property array $name
     * @property string $type
     * @property array|null $description
     * @property bool $is_active
     * @property float $price
     * @property float $signup_fee
     * @property string $currency
     * @property int $trial_period
     * @property string $trial_interval
     * @property int $invoice_period
     * @property string $invoice_interval
     * @property int $grace_period
     * @property string $grace_interval
     * @property int|null $prorate_day
     * @property int|null $prorate_period
     * @property int|null $prorate_extend_due
     * @property int|null $active_subscribers_limit
     * @property int $sort_order
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Premium\Feature> $features
     * @property-read int|null $features_count
     * @property-read array $translations
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Premium\Subscription> $subscriptions
     * @property-read int|null $subscriptions_count
     * @method static \Illuminate\Database\Eloquent\Builder|Plan developer()
     * @method static \Illuminate\Database\Eloquent\Builder|Plan enterprise()
     * @method static \Illuminate\Database\Eloquent\Builder|Plan newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Plan newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Plan onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Plan ordered(string $direction = 'asc')
     * @method static \Illuminate\Database\Eloquent\Builder|Plan query()
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereActiveSubscribersLimit($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereCurrency($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereGraceInterval($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereGracePeriod($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereInvoiceInterval($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereInvoicePeriod($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereIsActive($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan wherePrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereProrateDay($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereProrateExtendDue($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereProratePeriod($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereSignupFee($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereSortOrder($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereTrialInterval($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereTrialPeriod($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Plan withTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Plan withoutTrashed()
     * @mixin \Eloquent
     */
    final class IdeHelperPlan
    {
    }
}

namespace App\Models\Premium{
    /**
     * App\Models\Premium\Subscription
     *
     * @property int $id
     * @property string $subscriber_type
     * @property int $subscriber_id
     * @property int $plan_id
     * @property string $slug
     * @property array $name
     * @property array|null $description
     * @property \Illuminate\Support\Carbon|null $trial_ends_at
     * @property \Illuminate\Support\Carbon|null $starts_at
     * @property \Illuminate\Support\Carbon|null $ends_at
     * @property \Illuminate\Support\Carbon|null $cancels_at
     * @property \Illuminate\Support\Carbon|null $canceled_at
     * @property string|null $timezone
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property-read array $translations
     * @property-read \App\Models\Premium\Plan $plan
     * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $subscriber
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Premium\SubscriptionUsage> $usage
     * @property-read int|null $usage_count
     * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription byPlanId(int $planId)
     * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription findActive()
     * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription findEndedPeriod()
     * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription findEndedTrial()
     * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription findEndingPeriod(int $dayRange = 3)
     * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription findEndingTrial(int $dayRange = 3)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscription ofSubscriber(\Illuminate\Database\Eloquent\Model $subscriber)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription query()
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereCanceledAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereCancelsAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereEndsAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription wherePlanId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereStartsAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereSubscriberId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereSubscriberType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereTimezone($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereTrialEndsAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription withTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Subscription withoutTrashed()
     * @mixin \Eloquent
     */
    final class IdeHelperSubscription
    {
    }
}

namespace App\Models\Premium{
    /**
     * App\Models\Premium\SubscriptionUsage
     *
     * @property int $id
     * @property int $subscription_id
     * @property int $feature_id
     * @property int $used
     * @property \Illuminate\Support\Carbon|null $valid_until
     * @property string|null $timezone
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property-read \App\Models\Premium\Feature $feature
     * @property-read \App\Models\Premium\Subscription $subscription
     * @method static \Illuminate\Database\Eloquent\Builder|PlanSubscriptionUsage byFeatureSlug(string $featureSlug)
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage query()
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage whereFeatureId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage whereSubscriptionId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage whereTimezone($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage whereUsed($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage whereValidUntil($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage withTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|SubscriptionUsage withoutTrashed()
     * @mixin \Eloquent
     */
    final class IdeHelperSubscriptionUsage
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Reaction
     *
     * @property int $id
     * @property string $name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Reaction newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Reaction newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Reaction query()
     * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Reaction whereUpdatedAt($value)
     * @mixin \Eloquent
     */
    final class IdeHelperReaction
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Reply
     *
     * @property int $id
     * @property int $user_id
     * @property string $replyable_type
     * @property int $replyable_id
     * @property string $body
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Activity> $activity
     * @property-read int|null $activity_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, Reply> $allChildReplies
     * @property-read int|null $all_child_replies_count
     * @property-read Reply|null $latestReply
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reaction> $reactions
     * @property-read int|null $reactions_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, Reply> $replies
     * @property-read int|null $replies_count
     * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $replyAble
     * @property-read \App\Models\Thread|null $solutionTo
     * @property-read \App\Models\User $user
     * @method static \Database\Factories\ReplyFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder|Reply isSolution()
     * @method static \Illuminate\Database\Eloquent\Builder|Reply newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Reply newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Reply query()
     * @method static \Illuminate\Database\Eloquent\Builder|Reply whereBody($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Reply whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Reply whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Reply whereReplyableId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Reply whereReplyableType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Reply whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Reply whereUserId($value)
     * @mixin \Eloquent
     */
    final class IdeHelperReply
    {
    }
}

namespace App\Models{
    /**
     * App\Models\SocialAccount
     *
     * @property int $id
     * @property int $user_id
     * @property string $provider
     * @property string $provider_id
     * @property string|null $token
     * @property string|null $avatar
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|SocialAccount newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|SocialAccount newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|SocialAccount query()
     * @method static \Illuminate\Database\Eloquent\Builder|SocialAccount whereAvatar($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SocialAccount whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SocialAccount whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SocialAccount whereProvider($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SocialAccount whereProviderId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SocialAccount whereToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SocialAccount whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|SocialAccount whereUserId($value)
     * @mixin \Eloquent
     */
    final class IdeHelperSocialAccount
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Subscribe
     *
     * @property string $uuid
     * @property int $user_id
     * @property string $subscribeable_type
     * @property int $subscribeable_id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $subscribeAble
     * @property-read \App\Models\User $user
     * @method static \Illuminate\Database\Eloquent\Builder|Subscribe newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Subscribe newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Subscribe query()
     * @method static \Illuminate\Database\Eloquent\Builder|Subscribe whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscribe whereSubscribeableId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscribe whereSubscribeableType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscribe whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscribe whereUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Subscribe whereUuid($value)
     * @mixin \Eloquent
     */
    final class IdeHelperSubscribe
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Tag
     *
     * @property int $id
     * @property string $name
     * @property string $slug
     * @property string|null $description
     * @property array $concerns
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article> $articles
     * @property-read int|null $articles_count
     * @method static \Database\Factories\TagFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
     * @method static \Illuminate\Database\Eloquent\Builder|Tag whereConcerns($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Tag whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Tag whereSlug($value)
     * @mixin \Eloquent
     */
    final class IdeHelperTag
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Thread
     *
     * @property int $id
     * @property int $user_id
     * @property string $title
     * @property string $slug
     * @property string $body
     * @property int|null $solution_reply_id
     * @property int|null $resolved_by
     * @property bool $locked
     * @property \Illuminate\Support\Carbon $last_posted_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Activity> $activity
     * @property-read int|null $activity_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Channel> $channels
     * @property-read int|null $channels_count
     * @property-read \App\Models\Reply|null $latestReply
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
     * @property-read int|null $notifications_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reaction> $reactions
     * @property-read int|null $reactions_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reply> $replies
     * @property-read int|null $replies_count
     * @property-read \App\Models\User|null $resolvedBy
     * @property-read \App\Models\Reply|null $solutionReply
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscribe> $subscribes
     * @property-read int|null $subscribes_count
     * @property-read \App\Models\User $user
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \CyrildeWit\EloquentViewable\View> $views
     * @property-read int|null $views_count
     * @method static \Illuminate\Database\Eloquent\Builder|Thread active()
     * @method static \Database\Factories\ThreadFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder|Thread feedQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Thread filter(\Illuminate\Http\Request $request, array $filters = [])
     * @method static \Illuminate\Database\Eloquent\Builder|Thread forChannel(\App\Models\Channel $channel)
     * @method static \Illuminate\Database\Eloquent\Builder|Thread newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Thread newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Thread orderByUniqueViews(string $direction = 'desc', $period = null, ?string $collection = null, string $as = 'unique_views_count')
     * @method static \Illuminate\Database\Eloquent\Builder|Thread orderByViews(string $direction = 'desc', ?\CyrildeWit\EloquentViewable\Support\Period $period = null, ?string $collection = null, bool $unique = false, string $as = 'views_count')
     * @method static \Illuminate\Database\Eloquent\Builder|Thread query()
     * @method static \Illuminate\Database\Eloquent\Builder|Thread recent()
     * @method static \Illuminate\Database\Eloquent\Builder|Thread resolved()
     * @method static \Illuminate\Database\Eloquent\Builder|Thread unresolved()
     * @method static \Illuminate\Database\Eloquent\Builder|Thread whereBody($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Thread whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Thread whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Thread whereLastPostedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Thread whereLocked($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Thread whereResolvedBy($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Thread whereSlug($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Thread whereSolutionReplyId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Thread whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Thread whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Thread whereUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Thread withViewsCount(?\CyrildeWit\EloquentViewable\Support\Period $period = null, ?string $collection = null, bool $unique = false, string $as = 'views_count')
     * @mixin \Eloquent
     */
    final class IdeHelperThread
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Transaction
     *
     * @property string $id
     * @property string $type
     * @property int $user_id
     * @property int $amount
     * @property int|null $fees
     * @property string $transaction_reference
     * @property string $status
     * @property array|null $metadata
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\User $user
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction complete()
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction query()
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereAmount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereFees($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereMetadata($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereTransactionReference($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Transaction whereUserId($value)
     * @mixin \Eloquent
     */
    final class IdeHelperTransaction
    {
    }
}

namespace App\Models{
    /**
     * App\Models\User
     *
     * @property int $id
     * @property string $name
     * @property string $email
     * @property string $username
     * @property \Illuminate\Support\Carbon|null $email_verified_at
     * @property string|null $password
     * @property string|null $two_factor_secret
     * @property string|null $two_factor_recovery_codes
     * @property string|null $bio
     * @property string|null $location
     * @property string|null $avatar
     * @property string $avatar_type
     * @property string|null $phone_number
     * @property \Illuminate\Support\Carbon|null $last_login_at
     * @property string|null $last_login_ip
     * @property string|null $github_profile
     * @property string|null $twitter_profile
     * @property string|null $linkedin_profile
     * @property string|null $website
     * @property int $opt_in
     * @property array|null $settings
     * @property string|null $remember_token
     * @property int $reputation
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Activity> $activities
     * @property-read int|null $activities_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Article> $articles
     * @property-read int|null $articles_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \QCod\Gamify\Badge> $badges
     * @property-read int|null $badges_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Discussion> $discussions
     * @property-read int|null $discussions_count
     * @property-read \App\Models\Enterprise|null $enterprise
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \LaravelFeature\Model\Feature> $features
     * @property-read int|null $features_count
     * @property-read bool $is_sponsor
     * @property-read string|null $profile_photo_url
     * @property-read string $roles_label
     * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
     * @property-read int|null $media_count
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
     * @property-read int|null $notifications_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
     * @property-read int|null $permissions_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Premium\Subscription> $planSubscriptions
     * @property-read int|null $plan_subscriptions_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SocialAccount> $providers
     * @property-read int|null $providers_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reply> $replyAble
     * @property-read int|null $reply_able_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \QCod\Gamify\Reputation> $reputations
     * @property-read int|null $reputations_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
     * @property-read int|null $roles_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Subscribe> $subscriptions
     * @property-read int|null $subscriptions_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Thread> $threads
     * @property-read int|null $threads_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
     * @property-read int|null $tokens_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transaction> $transactions
     * @property-read int|null $transactions_count
     * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder|User hasActivity()
     * @method static \Illuminate\Database\Eloquent\Builder|User moderators()
     * @method static \Illuminate\Database\Eloquent\Builder|User mostSolutions(?int $inLastDays = null)
     * @method static \Illuminate\Database\Eloquent\Builder|User mostSolutionsInLastDays(int $days)
     * @method static \Illuminate\Database\Eloquent\Builder|User mostSubmissions(?int $inLastDays = null)
     * @method static \Illuminate\Database\Eloquent\Builder|User mostSubmissionsInLastDays(int $days)
     * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User permission($permissions)
     * @method static \Illuminate\Database\Eloquent\Builder|User query()
     * @method static \Illuminate\Database\Eloquent\Builder|User role($roles, $guard = null)
     * @method static \Illuminate\Database\Eloquent\Builder|User topContributors()
     * @method static \Illuminate\Database\Eloquent\Builder|User unVerifiedUsers()
     * @method static \Illuminate\Database\Eloquent\Builder|User verifiedUsers()
     * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatarType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereBio($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereGithubProfile($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginIp($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereLinkedinProfile($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereLocation($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereOptIn($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User wherePhoneNumber($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereReputation($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereSettings($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereTwitterProfile($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereWebsite($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User withCounts()
     * @method static \Illuminate\Database\Eloquent\Builder|User withoutRole()
     * @mixin \Eloquent
     */
    final class IdeHelperUser
    {
    }
}
