<?php

declare(strict_types=1);

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class FAQs extends SpotlightCommand
{
    protected string $name = 'FAQs';

    protected string $description = 'aller à la page des questions';

    /**
     * @var string[]
     */
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
