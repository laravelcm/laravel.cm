<?php

namespace App\Http\Livewire\Articles;

use App\Models\Tag;
use Livewire\Component;

class Create extends Component
{
    public ?string $title = null;
    public array $tags_selected = [];

    public function rules(): array
    {
        return [
            'title' => ['required', 'max:100'],
            'body' => ['required'],
            'tags_selected' => 'array|nullable',
            'tags.*' => 'exists:tags,id',
            'canonical_url' => 'url|nullable',
            'submitted' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Le titre de l\'article est requis',
        ];
    }

    public function store()
    {

    }

    public function render()
    {
        return view('livewire.articles.create', [
            'tags' => Tag::whereJsonContains('concerns', ['post'])->pluck('name', 'id'),
        ]);
    }
}
