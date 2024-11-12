<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Actions\ReportSpamAction;
use App\Models\SpamReport;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

final class ReportSpam extends Component
{
    public $recordId;

    public $recordType;

    public $reason;

    public $alreadyReported;

    public $isModalOpen = false;

    public function mount($recordId, $recordType): void
    {
        $this->recordId = $recordId;
        $this->recordType = $recordType;
        $this->alreadyReported = SpamReport::where('user_id', Auth::id())
            ->where('reportable_id', $recordId)
            ->where('reportable_type', $recordType)
            ->exists();
    }

    public function openModal(): void
    {
        $this->isModalOpen = true;
    }

    public function closeModal(): void
    {
        $this->isModalOpen = false;
        $this->reset('reason');
    }

    public function report(): void
    {
        $user = Auth::user();

        if (! $user) {
            abort(403, 'Vous devez être connecté pour signaler du contenu.');
        }

        if (! $user->hasVerifiedEmail()) {
            abort(403, 'Vous devez avoir un email vérifié pour signaler du contenu');
        }

        try {
            app(ReportSpamAction::class)->execute([
                'user' => $user,
                'recordId' => $this->recordId,
                'recordType' => $this->recordType,
                'reason' => $this->reason,
            ]);

            $this->reset('reason');

            session()->flash('message', 'Signalement créé avec succès');

        } catch (\Exception $e) {
            if ($e->getMessage() === 'already_reported') {
                $this->addError('alreadyReported', 'Vous avez déjà signalé ce contenu.');
            } else {
                session()->flash('error', 'Une erreur est survenue lors du signalement.');
            }
        }
    }

    public function render()
    {
        return view('livewire.components.spam-report');
    }
}
