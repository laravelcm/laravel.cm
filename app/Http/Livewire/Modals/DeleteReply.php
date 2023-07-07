<?php

declare(strict_types=1);

namespace App\Http\Livewire\Modals;

use App\Models\Reply;
use App\Policies\ReplyPolicy;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

final class DeleteReply extends ModalComponent
{
    use AuthorizesRequests;

    public ?Reply $reply = null;

    public string $slug;

    public function mount(int $id, string $slug): void
    {
        $this->reply = Reply::find($id);
        $this->slug = $slug;
    }

    public function delete(): void
    {
        $this->authorize(ReplyPolicy::DELETE, $this->reply);

        $this->reply->delete(); // @phpstan-ignore-line

        session()->flash('status', __('La réponse a ete supprimée avec succès.'));

        $this->redirect('/forum/'.$this->slug);
    }

    public function render(): View
    {
        return view('livewire.modals.delete-reply');
    }
}
