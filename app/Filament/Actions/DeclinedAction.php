<?php

namespace App\Filament\Actions;

use Filament\Actions\Concerns\CanCustomizeProcess;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Database\Eloquent\Model;

class DeclinedAction extends \Filament\Tables\Actions\Action
{
    use CanCustomizeProcess;
    public static function getDefaultName(): ?string
    {
        return 'declined';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('Décliner'));

        $this->modalHeading(fn (): string => __('Voulez vous décliner cet article', ['label' => $this->getRecordTitle()]));

        $this->modalSubmitActionLabel(__('Décliner'));

        $this->successNotificationTitle(__('Opération effectuée avec succès'));

        $this->color('warning');

        $this->icon( 'heroicon-s-check');

        $this->requiresConfirmation();

        $this->modalIcon('heroicon-s-check');

        $this->action(function (): void {
            $result = $this->process(static fn (Model $record) => $record->update(['declined_at' => now(), 'approved_at' => null]));

            if (! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });
    }
}
