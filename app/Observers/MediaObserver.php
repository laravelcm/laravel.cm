<?php

declare(strict_types=1);

namespace App\Observers;

use App\Contracts\HasCachedMediaInterface;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

final class MediaObserver
{
    public function created(Media $media): void
    {
        $this->flushModelMediaCache($media);
    }

    public function updated(Media $media): void
    {
        $this->flushModelMediaCache($media);
    }

    public function deleted(Media $media): void
    {
        $this->flushModelMediaCache($media);
    }

    private function flushModelMediaCache(Media $media): void
    {
        $model = $media->model;

        if ($model instanceof HasCachedMediaInterface) {
            $model->flushMediaCache($media->collection_name);
        }
    }
}
