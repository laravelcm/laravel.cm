<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentType: string
{
    case SUBSCRIPTION = 'subscription';

    case SPONSORING = 'sponsoring';
}
