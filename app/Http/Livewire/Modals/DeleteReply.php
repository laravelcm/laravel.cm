<?php

namespace App\Http\Livewire\Modals;

use App\Models\Reply;
use App\Policies\ReplyPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

class DeleteReply extends ModalComponent
{
    use AuthorizesRequests;

    public ?Reply $reply = null;
    public string $slug;

    public function mount($id, string $slug)
    {
        $this->reply = Reply::find($id);
        $this->slug = $slug;
    }

    public function delete()
    {
        $this->authorize(ReplyPolicy::DELETE, $this->reply);

        $this->reply->delete();

        session()->flash('status', 'La réponse a ete supprimée avec succès.');

        $this->redirect('/forum/' . $this->slug);
    }

    public function render()
    {
        return view('livewire.modals.delete-reply');
    }
}
