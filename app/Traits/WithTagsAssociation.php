<?php

declare(strict_types=1);

namespace App\Traits;

use Livewire\Attributes\Validate;

trait WithTagsAssociation
{
    /**
     * @var array<string, string>
     */
    #[Validate('nullable|array')]
    public array $tags_selected = [];

    /**
     * @var int[]
     */
    public array $associateTags = [];

    /**
     * @param  array{value: string}  $choices
     */
    public function updatedTagsSelected($choices): void
    {
        $choices = (array) $choices;
        foreach ($choices as $choice) {
            if (! in_array($choice, $this->associateTags)) {
                $this->associateTags[] = (int) $choice;
            } else {
                $key = array_search((int) $choice, $this->associateTags);
                unset($this->associateTags[$key]);
            }
        }
    }
}
