<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\Article;
use Illuminate\Queue\SerializesModels;

final class ArticleWasSubmittedForApproval
{
    use SerializesModels;

    public function __construct(public Article $article)
    {
    }
}
