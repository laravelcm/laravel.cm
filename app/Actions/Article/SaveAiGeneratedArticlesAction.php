<?php

declare(strict_types=1);

namespace App\Actions\Article;

use App\Models\Article;
use App\Models\Tag;
use App\Models\User;
use Closure;

final class SaveAiGeneratedArticlesAction
{
    /**
     * @param  list<array{title: string, body: string, tags?: list<string>}>  $articles
     * @param  Closure(Article): void|null  $onSaved
     * @return list<Article>
     */
    public function execute(array $articles, ?Closure $onSaved = null): array
    {
        $botUser = User::query()
            ->where('email', config('lcm.ai_author_email'))
            ->firstOrFail();

        $saved = [];

        foreach ($articles as $article) {
            /** @var Article $post */
            $post = Article::query()->create([
                'title' => $article['title'],
                'slug' => $article['title'],
                'body' => $article['body'],
                'locale' => 'fr',
                'show_toc' => true,
                'submitted_at' => now(),
                'user_id' => $botUser->id,
            ]);

            if (isset($article['tags']) && filled($article['tags'])) {
                $post->syncTags($this->resolveTagIds($article['tags']));
            }

            if ($onSaved instanceof Closure) {
                $onSaved($post);
            }

            $saved[] = $post;
        }

        return $saved;
    }

    /**
     * @param  list<string>  $tagNames
     * @return array<int, int>
     */
    private function resolveTagIds(array $tagNames): array
    {
        return collect($tagNames)
            ->map(function (string $name): ?int {
                /** @var int|null */
                return Tag::query()
                    ->whereRaw('LOWER(name) = ?', [mb_strtolower($name)])
                    ->value('id');
            })
            ->filter()
            ->values()
            ->all();
    }
}
