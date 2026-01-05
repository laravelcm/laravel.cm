<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Discussion;
use Illuminate\Validation\Rule;
use Livewire\Form;

final class DiscussionFormObject extends Form
{
    public ?int $id = null;

    public ?int $user_id = null;

    public string $title = '';

    public string $slug = '';

    /** @var array<int> */
    public array $tags = [];

    public string $locale = 'fr';

    public string $body = '';

    public function setDiscussion(Discussion $discussion): void
    {
        /** @var int $authId */
        $authId = auth()->id();

        $this->id = $discussion->id;
        $this->user_id = $discussion->user_id ?? $authId;
        $this->title = $discussion->title ?? '';
        $this->slug = $discussion->slug ?? '';

        /** @var array<int> $tags */
        $tags = $discussion->tags->pluck('id')->toArray();
        $this->tags = $tags;

        $this->locale = $discussion->locale ?? app()->getLocale();
        $this->body = $discussion->body ?? '';
    }

    protected function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'title' => ['required', 'string', 'min:10'],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('discussions', 'slug')->ignore($this->id),
            ],
            'tags' => ['required', 'array', 'min:1', 'max:3'],
            'tags.*' => ['required', 'integer', 'exists:tags,id'],
            'locale' => ['required', 'string', Rule::in(['en', 'fr'])],
            'body' => ['required', 'string', 'min:20'],
        ];
    }
}
