<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Thread;
use Illuminate\Validation\Rule;
use Livewire\Form;

final class ThreadFormObject extends Form
{
    public ?int $id = null;

    public ?int $user_id = null;

    public string $title = '';

    public string $slug = '';

    /** @var array<int> */
    public array $channels = [];

    public string $locale = 'fr';

    public string $body = '';

    public function setThread(Thread $thread): void
    {
        /** @var int $authId */
        $authId = auth()->id();

        $this->id = $thread->id;
        $this->user_id = $thread->user_id ?? $authId;
        $this->title = $thread->title ?? '';
        $this->slug = $thread->slug ?? '';

        /** @var array<int> $channels */
        $channels = $thread->channels->pluck('id')->toArray();
        $this->channels = $channels;

        $this->locale = $thread->locale ?? app()->getLocale();
        $this->body = $thread->body ?? '';
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
                Rule::unique('threads', 'slug')->ignore($this->id),
            ],
            'channels' => ['required', 'array', 'min:1', 'max:3'],
            'channels.*' => ['required', 'integer', 'exists:channels,id'],
            'locale' => ['required', 'string', Rule::in(['en', 'fr'])],
            'body' => ['required', 'string', 'min:20'],
        ];
    }
}
