<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PlanType extends Enum
{
    public const DEVELOPER = 'developer';

    public const ENTERPRISE = 'enterprise';
}
