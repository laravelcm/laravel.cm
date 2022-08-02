<?php

namespace App\Traits;

trait WithTagsAssociation
{
    public array $tags_selected = [];

    public array $associateTags = [];

    public function updatedTagsSelected($choices)
    {
        if (! in_array($choices['value'], $this->associateTags)) {
            array_push($this->associateTags, $choices['value']);
        } else {
            $key = array_search($choices['value'], $this->associateTags);
            unset($this->associateTags[$key]);
        }
    }
}
