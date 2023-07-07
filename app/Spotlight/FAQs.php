<?php

declare(strict_types=1);

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

final class FAQs extends SpotlightCommand
{
    protected string $name = 'FAQs';

    protected string $description = 'aller à la page des questions';

    protected array $synonyms = [
        'faq',
        'question',
        'foire',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('faq');
    }
}
