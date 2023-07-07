<?php

declare(strict_types=1);

namespace App\Http\Livewire\Modals;

use App\Models\Discussion;
use App\Policies\DiscussionPolicy;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LivewireUI\Modal\ModalComponent;

final class DeleteDiscussion extends ModalComponent
{
    use AuthorizesRequests;

    public ?Discussion $discussion = null;

    public function mount(int $id): void
    {
        $this->discussion = Discussion::find($id);
    }

    public static function modalMaxWidth(): string
    {
        return 'xl';
    }

    public function delete(): void
    {
        $this->authorize(DiscussionPolicy::DELETE, $this->discussion);

        $this->discussion->delete(); // @phpstan-ignore-line

        session()->flash('status', __('La discussion a été supprimé avec tous ses commentaires.'));

        $this->redirectRoute('discussions.index');
    }

    public function render(): View
    {
        return view('livewire.modals.delete-discussion');
    }
}
