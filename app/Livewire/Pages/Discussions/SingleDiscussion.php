<?php

declare(strict_types=1);

namespace App\Livewire\Pages\Discussions;

use App\Actions\Discussion\ConvertDiscussionToThreadAction;
use App\Actions\Discussion\DeleteDiscussionAction;
use App\Models\Discussion;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\DeleteAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class SingleDiscussion extends Component implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Discussion $discussion;

    public function mount(Discussion $discussion): void
    {
        views($discussion)->cooldown(now()->addHours(2))->record();

        // @phpstan-ignore-next-line
        seo()
            ->title($discussion->title)
            ->description($discussion->excerpt(100))
            ->image(asset('images/socialcard.png'))
            ->twitterTitle($discussion->title)
            ->twitterDescription($discussion->excerpt(100))
            ->twitterImage(asset('images/socialcard.png'))
            ->twitterSite('laravelcd')
            ->withUrl();

        $this->discussion = $discussion->load('tags', 'replies', 'reactions', 'replies.user');
    }

    public function editAction(): Action
    {
        return Action::make('edit')
            ->label(__('actions.edit'))
            ->color('gray')
            ->authorize('update', $this->discussion)
            ->action(
                fn () => $this->dispatch(
                    'openPanel',
                    component: 'components.slideovers.discussion-form',
                    arguments: ['discussionId' => $this->discussion->id]
                )
            );
    }

    public function convertedToThreadAction(): Action
    {
        return Action::make('convertedToThread')
            ->label(__('pages/discussion.convert_to_thread'))
            ->color('primary')
            ->authorize('convertedToThread', $this->discussion)
            ->requiresConfirmation()
            ->modalIcon()
            ->modalHeading(__('pages/discussion.convert_to_thread'))
            ->modalDescription(__('pages/discussion.text_confirmation'))
            ->action(function (): void {
                $thread = app(ConvertDiscussionToThreadAction::class)->execute($this->discussion);

                $this->redirectRoute('forum.show', $thread, navigate: true);
            });
    }

    public function deleteAction(): Action
    {
        return DeleteAction::make()
            ->record($this->discussion)
            ->label(__('actions.delete'))
            ->authorize('delete', $this->discussion)
            ->requiresConfirmation()
            ->successNotificationTitle(__('notifications.discussion.deleted'))
            ->action(function (): void {

                app(DeleteDiscussionAction::class)->execute($this->discussion);

                $this->redirectRoute('discussions.index',  navigate: true);
            });
    }

    public function render(): View
    {
        return view('livewire.pages.discussions.single-discussion')
            ->title($this->discussion->title);
    }
}
