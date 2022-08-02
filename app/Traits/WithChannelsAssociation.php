<?php

namespace App\Traits;

trait WithChannelsAssociation
{
    public array $channels_selected = [];

    public array $associateChannels = [];

    public function updatedChannelsSelected($choices)
    {
        if (! in_array($choices['value'], $this->associateChannels)) {
            array_push($this->associateChannels, $choices['value']);
        } else {
            $key = array_search($choices['value'], $this->associateChannels);
            unset($this->associateChannels[$key]);
        }
    }
}
