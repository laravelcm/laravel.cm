<?php

declare(strict_types=1);

namespace App\Http\Livewire\Modals;

use App\Models\Thread;
use App\Policies\ThreadPolicy;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

final class DeleteThread extends ModalComponent
{
    use AuthorizesRequests;

    public ?Thread $thread = null;

    public function mount(int $id): void
    {
        $this->thread = Thread::find($id);
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function delete(): void
    {
        $this->authorize(ThreadPolicy::DELETE, $this->thread);

        $this->thread->delete(); // @phpstan-ignore-line

        session()->flash('status', __('Le sujet a été supprimé avec toutes ses réponses.'));

        $this->redirectRoute('forum.index');
    }

    public function render(): View
    {
        return view('livewire.modals.delete-thread');
    }
}
