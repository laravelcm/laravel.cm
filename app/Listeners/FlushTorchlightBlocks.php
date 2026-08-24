<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Markdown\BaseExtension;

final class FlushTorchlightBlocks
{
    public function handle(): void
    {
        BaseExtension::$torchlightBlocks = [];
    }
}
