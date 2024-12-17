<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\Article;
use QCod\Gamify\PointType;

final class ArticleDeleted extends PointType
{
    public int $points = 50;

    protected string $payee = 'user';

    public function __construct(Article $subject)
    {
        $this->subject = $subject;
    }
}
