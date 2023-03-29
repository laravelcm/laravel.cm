<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\SocialAccount;

trait HasProfilePhoto
{
    public function getProfilePhotoUrlAttribute(): ?string
    {
        if ($this->avatar_type === 'storage') {
            return $this->getFirstMediaUrl('avatar');
        }

        if (! in_array($this->avatar_type, ['avatar', 'storage'])) {
            /** @var SocialAccount $social_avatar */
            $social_avatar = $this->providers->firstWhere('provider', $this->avatar_type);

            return $social_avatar->avatar;
        }

        return $this->defaultProfilePhotoUrl();
    }

    protected function defaultProfilePhotoUrl(): ?string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=065F46&background=D1FAE5';
    }
}
