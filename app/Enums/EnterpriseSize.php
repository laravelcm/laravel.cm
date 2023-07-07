<?php

declare(strict_types=1);

namespace App\Enums;

enum EnterpriseSize: string
{
    case SEED = '1-10';

    case SMALL = '11-50';

    case MEDIUM = '51-200';

    case LARGE = '201-500';

    case VERY_LARGE = '501-1000';

    case ENTERPRISE = '1001-5000';

    case LARGE_ENTERPRISE = '5000+';
}
