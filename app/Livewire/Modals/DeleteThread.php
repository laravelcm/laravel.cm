<?php

declare(strict_types=1);

namespace App\Livewire\Modals;

use App\Models\Thread;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

final class DeleteThread extends ModalComponent
{
    use AuthorizesRequests;

    public ?Thread $thread = null;

    public function mount(int $id): void
    {
        $this->thread = Thread::query()->find($id);
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->thread);

        $this->thread?->delete();

        session()->flash('status', __('Le sujet a été supprimé avec toutes ses réponses.'));

        $this->redirectRoute('forum.index');
    }

    public function render(): View
    {
        return view('livewire.modals.delete-thread');
    }
}
