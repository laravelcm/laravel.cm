<?php

declare(strict_types=1);

namespace App\Enums;

enum TransactionStatus: string
{
    case PENDING = 'pending';

    case COMPLETE = 'complete';

    case CANCELED = 'canceled';

    case Failed = 'failed';
}
