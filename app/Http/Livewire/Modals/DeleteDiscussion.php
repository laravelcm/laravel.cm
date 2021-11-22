<?php

namespace App\Http\Livewire\Modals;

use App\Models\Discussion;
use App\Policies\DiscussionPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

class DeleteDiscussion extends ModalComponent
{
    use AuthorizesRequests;

    public ?Discussion $discussion = null;

    public function mount($id)
    {
        $this->discussion = Discussion::find($id);
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function delete()
    {
        $this->authorize(DiscussionPolicy::DELETE, $this->discussion);

        $this->discussion->delete();

        session()->flash('status', 'La discussion a été supprimé avec tous ses commentaires.');

        $this->redirectRoute('discussions.index');
    }

    public function render()
    {
        return view('livewire.modals.delete-discussion');
    }
}
