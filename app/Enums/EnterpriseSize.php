<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class EnterpriseSize extends Enum
{
    public const SEED = '1-10';

    public const SMALL = '11-50';

    public const MEDIUM = '51-200';

    public const LARGE = '201-500';

    public const VERY_LARGE = '501-1000';

    public const ENTERPRISE = '1001-5000';

    public const LARGE_ENTERPRISE = '5000+';
}
