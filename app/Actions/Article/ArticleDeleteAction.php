<?php

declare(strict_types=1);

namespace App\Actions\Article;

use App\Models\Article;
use Illuminate\Support\Facades\DB;

final class ArticleDeleteAction
{
    public function execute(Article $article): void
    {
        DB::beginTransaction();

        $article->delete();

        DB::commit();
    }
}
