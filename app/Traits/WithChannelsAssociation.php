<?php

declare(strict_types=1);

namespace App\Traits;

trait WithChannelsAssociation
{
    /**
     * @var array<string, string>
     */
    public array $channels_selected = [];

    /**
     * @var array<int|string, string>
     */
    public array $associateChannels = [];

    /**
     * @param array{value: string} $choices
     */
    public function updatedChannelsSelected(array $choices): void
    {
        if (! in_array($choices['value'], $this->associateChannels)) {
            $this->associateChannels[] = $choices['value'];
        } else {
            $key = array_search($choices['value'], $this->associateChannels);
            unset($this->associateChannels[$key]);
        }
    }
}
