<?php

declare(strict_types=1);

namespace App\Traits;

trait WithTagsAssociation
{
    /**
     * @var array<string, string>
     */
    public array $tags_selected = [];

    /**
     * @var int[]
     */
    public array $associateTags = [];

    /**
     * @param array{value: string} $choices
     */
    public function updatedTagsSelected(array $choices): void
    {
        if ( ! in_array($choices['value'], $this->associateTags)) {
            $this->associateTags[] = (int) $choices['value'];
        } else {
            $key = array_search((int) $choices['value'], $this->associateTags);
            unset($this->associateTags[$key]);
        }
    }
}
