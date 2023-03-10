<?php

namespace App\Traits;

trait HasProfilePhoto
{
    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->avatar_type === 'storage') {
            return $this->getFirstMediaUrl('avatar');
        }

        if (! in_array($this->avatar_type, ['avatar', 'storage'])) {
            $social_avatar = $this->providers->firstWhere('provider', $this->avatar_type);

            if ($social_avatar && strlen($social_avatar->avatar)) {
                return $social_avatar->avatar;
            }
        }

        return $this->defaultProfilePhotoUrl();
    }

    protected function defaultProfilePhotoUrl(): string
    {
        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&color=065F46&background=D1FAE5';
    }
}
