<?php

declare(strict_types=1);

namespace App\Gamify\Points;

use App\Models\Article;
use App\Models\User;
use QCod\Gamify\PointType;

/**
 * @method Article getSubject()
 */
final class PostCreated extends PointType
{
    public int $points = 50;

    public function __construct(Article $subject)
    {
        $this->subject = $subject;
    }

    public function payee(): User
    {
        return $this->getSubject()->user;
    }
}
