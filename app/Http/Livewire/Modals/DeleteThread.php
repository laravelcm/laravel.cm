<?php

declare(strict_types=1);

namespace App\Http\Livewire\Modals;

use App\Models\Thread;
use App\Policies\ThreadPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

class DeleteThread extends ModalComponent
{
    use AuthorizesRequests;

    public ?Thread $thread = null;

    public function mount($id)
    {
        $this->thread = Thread::find($id);
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function delete()
    {
        $this->authorize(ThreadPolicy::DELETE, $this->thread);

        $this->thread->delete();

        session()->flash('status', 'Le sujet a été supprimé avec toutes ses réponses.');

        $this->redirectRoute('forum.index');
    }

    public function render()
    {
        return view('livewire.modals.delete-thread');
    }
}
