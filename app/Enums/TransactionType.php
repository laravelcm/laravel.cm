<?php

declare(strict_types=1);

namespace App\Enums;

enum TransactionType: string
{
    case ONETIME = 'one-time';

    case RECURSIVE = 'recursive';
}
