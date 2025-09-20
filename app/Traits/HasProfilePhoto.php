<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\SocialAccount;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Cache;

trait HasProfilePhoto
{
    use HasCachedMedia;

    protected function profilePhotoUrl(): Attribute
    {
        return Attribute::get(fn (): string => Cache::remember(
            "user.{$this->id}.profile_photo_url",
            now()->addYear(),
            fn (): string => $this->resolveProfilePhotoUrl()
        ));
    }

    public function getMediaCollections(): array
    {
        return ['avatar'];
    }

    public function flushAvatarCache(): void
    {
        Cache::forget("user.{$this->id}.profile_photo_url");

        $this->flushMediaCache('avatar');
    }

    private function resolveProfilePhotoUrl(): string
    {
        if ($this->avatar_type === 'storage') {
            return $this->getCachedMediaUrl('avatar') ?? $this->defaultProfilePhotoUrl();
        }

        if (! in_array($this->avatar_type, ['avatar', 'storage'])) {
            $this->loadMissing('providers');

            /** @var SocialAccount $social_avatar */
            $social_avatar = $this->providers->firstWhere('provider', $this->avatar_type);

            return $social_avatar->avatar ?? $this->defaultProfilePhotoUrl();
        }

        return $this->defaultProfilePhotoUrl();
    }

    protected function defaultProfilePhotoUrl(): string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=065F46&background=D1FAE5';
    }
}
