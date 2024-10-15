<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use Filament\Actions\Concerns\CanCustomizeProcess;
use Illuminate\Database\Eloquent\Model;

final class ApprovedAction extends \Filament\Tables\Actions\Action
{
    use CanCustomizeProcess;

    public static function getDefaultName(): ?string
    {
        return 'approved';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('Approuver'));

        $this->modalHeading(fn (): string => __('Voulez vous approuver cet article', ['label' => $this->getRecordTitle()]));

        $this->modalSubmitActionLabel(__('Approuver'));

        $this->successNotificationTitle(__('Opération effectuée avec succès'));

        $this->color('success');

        $this->icon('heroicon-s-x-mark');

        $this->requiresConfirmation();

        $this->modalIcon('heroicon-s-x-mark');

        $this->action(function (): void {
            $result = $this->process(static fn (Model $record) => $record->update(['approved_at' => now(), 'declined_at' => null]));

            if ( ! $result) {
                $this->failure();

                return;
            }

            $this->success();
        });
    }
}
