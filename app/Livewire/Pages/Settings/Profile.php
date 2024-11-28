<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Settings;

use Filament\Forms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class Profile extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    public $description;

    public function mount(): void
    {
        $this->form->fill([
            'bio' => Auth::user()->bio,
        ]);
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Textarea::make('description')
                ->label('bio')
                ->placeholder('Enter your description here...')
                ->rows(5)

                ->required(),
        ];
    }

    public function render(): View
    {
        return view('livewire.pages.settings.profile');
    }
}
