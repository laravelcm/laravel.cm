<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PlanType extends Enum
{
    const DEVELOPER = 'developer';

    const ENTERPRISE = 'enterprise';
}
