<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class EnterpriseSize extends Enum
{
    const SEED = '1-10';
    const SMALL = '11-50';
    const MEDIUM = '51-200';
    const LARGE = '201-500';
    const VERY_LARGE = '501-1000';
    const ENTERPRISE = '1001-5000';
    const LARGE_ENTERPRISE = '5000+';
}
