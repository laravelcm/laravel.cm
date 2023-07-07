<?php

declare(strict_types=1);

namespace App\Enums;

enum PlanType: string
{
    case DEVELOPER = 'developer';

    case ENTERPRISE = 'enterprise';
}
