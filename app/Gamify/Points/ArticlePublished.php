<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\Article;
use Laravelcm\Gamify\PointType;

final class ArticlePublished extends PointType
{
    /** @var int */
    public $points = 50;

    /** @var string */
    public $payee = 'user';

    public function __construct(Article $subject)
    {
        $this->subject = $subject;
    }
}
