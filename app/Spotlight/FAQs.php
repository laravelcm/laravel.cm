<?php

namespace App\Spotlight;

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class FAQs extends SpotlightCommand
{
    protected string $name = 'FAQs';

    protected string $description = 'aller à la page des questions';

    protected array $synonyms = [
        'faq',
        'question',
        'foire',
    ];

    /**
     * When all dependencies have been resolved the execute method is called.
     * You can type-hint all resolved dependency you defined earlier.
     */
    public function execute(Spotlight $spotlight)
    {
        $spotlight->redirectRoute('faq');
    }
}
