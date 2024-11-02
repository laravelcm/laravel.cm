<?php

declare(strict_types=1);

namespace App\Livewire\Modals;

use App\Models\Reply;
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
        $this->reply = Reply::query()->find($id);
        $this->slug = $slug;
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->reply);

        $this->reply?->delete();

        session()->flash('status', __('La réponse a ete supprimée avec succès.'));

        $this->redirect('/forum/'.$this->slug);
    }

    public function render(): View
    {
        return view('livewire.modals.delete-reply');
    }
}
