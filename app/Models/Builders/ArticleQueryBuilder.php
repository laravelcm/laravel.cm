<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModelClass of Article
 */
final class ArticleQueryBuilder extends Builder
{
    public function submitted(): self
    {
        return $this->whereNotNull('submitted_at');
    }

    public function approved(): self
    {
        return $this->whereNotNull('approved_at');
    }

    public function notApproved(): self
    {
        return $this->whereNull('approved_at');
    }

    public function published(): self
    {
        return $this->whereDate('published_at', '<=', now())
            ->submitted()
            ->approved();
    }

    public function notPublished(): self
    {
        return $this->where(function (Builder $query): void {
            $query->whereNull('submitted_at')
                ->orWhereNull('approved_at')
                ->orWhereNull('published_at')
                ->orWhereNotNull('declined_at');
        });
    }

    public function pinned(): self
    {
        return $this->where('is_pinned', true);
    }

    public function notPinned(): self
    {
        return $this->where('is_pinned', false);
    }

    public function shared(): self
    {
        return $this->whereNotNull('shared_at');
    }

    public function notShared(): self
    {
        return $this->whereNull('shared_at');
    }

    public function declined(): self
    {
        return $this->whereNotNull('declined_at');
    }

    public function sponsored(): self
    {
        return $this->whereNotNull('sponsored_at');
    }

    public function notDeclined(): self
    {
        return $this->whereNull('declined_at');
    }

    public function awaitingApproval(): self
    {
        return $this->submitted()
            ->notApproved()
            ->notDeclined();
    }

    public function recent(): self
    {
        return $this->orderByDesc('published_at')
            ->orderByDesc('created_at');
    }

    public function popular(): self
    {
        return $this->withCount('reactions')
            ->orderBy('reactions_count', 'desc')
            ->orderBy('published_at', 'desc');
    }

    public function trending(): self
    {
        return $this->withCount(['reactions' => function (Builder $query): void {
            $query->where('created_at', '>=', now()->subWeek());
        }])
            ->orderBy('reactions_count', 'desc')
            ->orderBy('published_at', 'desc');
    }
}
