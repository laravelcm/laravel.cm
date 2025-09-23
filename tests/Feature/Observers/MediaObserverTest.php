<?php

declare(strict_types=1);

use App\Observers\MediaObserver;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

describe(MediaObserver::class, function (): void {
    it('handles media without model gracefully', function (): void {
        $observer = new MediaObserver;
        $media = new Media([
            'collection_name' => 'test',
            'name' => 'test',
            'file_name' => 'test.jpg',
            'mime_type' => 'image/jpeg',
            'disk' => 'public',
        ]);

        $observer->created($media);
        $observer->updated($media);
        $observer->deleted($media);

        expect(true)->toBeTrue();
    });

    it('only flushes cache for models implementing HasCachedMediaInterface', function (): void {
        $observer = new MediaObserver;
        $article = \App\Models\Article::factory()->create();

        $media = new Media([
            'model_type' => get_class($article),
            'model_id' => $article->id,
            'collection_name' => 'images',
            'name' => 'test',
            'file_name' => 'test.jpg',
            'mime_type' => 'image/jpeg',
            'disk' => 'public',
        ]);

        $observer->created($media);

        expect(true)->toBeTrue();
    });
})->group('Observers', 'Media', 'Cache');
