# Laravel Markdown Editor

GitHub-style markdown editor for Laravel with Livewire and Alpine.js. This module provides a complete, standalone markdown editing experience with full dark mode support.

## Features

- 🎨 GitHub-style toolbar with all formatting options
- 📝 Live markdown preview
- 🌓 Full dark mode support
- 📎 File upload with automatic markdown insertion
- ✨ GitHub Flavored Markdown (GFM) support
- 📋 Tables, task lists, and more
- 🔄 Livewire integration with two-way binding
- 🎯 Multiple editor instances support

## Installation

### 1. Install NPM dependencies

```bash
cd app-modules/markdown-editor
npm install
```

### 2. Build assets

Add the module's JavaScript to your main `resources/js/app.js`:

```javascript
import '../../app-modules/markdown-editor/resources/js/markdown-editor.js';
```

Then build:

```bash
vendor/bin/sail npm run build
```

### 3. Register the module

The service provider is auto-discovered via Laravel's package discovery.

## Usage

### Basic Usage

```blade
<livewire:markdown-editor wire:model="content" />
```

### With Custom Configuration

```blade
<livewire:markdown-editor
    wire:model="comment"
    placeholder="Write your comment..."
    :rows="15"
    :show-toolbar="true"
    :show-upload="true"
/>
```

### In Livewire Components

```php
use Livewire\Component;

class CreatePost extends Component
{
    public string $content = '';

    public function save()
    {
        $this->validate([
            'content' => 'required|min:10',
        ]);

        // $this->content contains the markdown
    }

    public function render()
    {
        return view('livewire.create-post');
    }
}
```

```blade
<div>
    <livewire:markdown-editor wire:model="content" />

    <button wire:click="save">Save</button>
</div>
```

## Component Properties

| Property | Type | Default | Description |
|----------|------|---------|-------------|
| `content` | string | `''` | The markdown content (use with `wire:model`) |
| `placeholder` | string | `'Leave a comment...'` | Textarea placeholder text |
| `rows` | int | `10` | Number of textarea rows |
| `showToolbar` | bool | `true` | Show/hide the markdown toolbar |
| `showUpload` | bool | `true` | Show/hide the file upload button |

## Toolbar Features

- **Bold** - Make text bold
- **Italic** - Make text italic
- **Heading** - Insert heading
- **Quote** - Insert blockquote
- **Code** - Insert code block
- **Link** - Insert link
- **Unordered List** - Insert bullet list
- **Ordered List** - Insert numbered list
- **Task List** - Insert checklist
- **File Upload** - Upload and insert files/images

## File Uploads

Files are automatically uploaded to `storage/app/public/markdown-uploads/` when selected. Images are inserted as `![filename](url)` and other files as `[filename](url)`.

Make sure your storage is properly configured:

```bash
vendor/bin/sail artisan storage:link
```

## Markdown Support

The editor supports full GitHub Flavored Markdown including:

- Headings
- Bold, italic, strikethrough
- Links and images
- Code blocks with syntax highlighting
- Tables
- Task lists
- Blockquotes
- Horizontal rules

## Dark Mode

Dark mode is fully supported and automatically follows your Tailwind CSS dark mode configuration.

## Customization

### Publishing Views

```bash
vendor/bin/sail artisan vendor:publish --tag=markdown-editor-views
```

Views will be published to `resources/views/vendor/markdown-editor/`.

### Publishing Assets

```bash
vendor/bin/sail artisan vendor:publish --tag=markdown-editor-assets
```

Assets will be published to `resources/js/vendor/markdown-editor/`.

## Dependencies

- Laravel 11+ or 12+
- Livewire 3+
- Alpine.js (included with Livewire)
- Tailwind CSS
- League CommonMark
- GitHub Markdown Toolbar Element
- GitHub Text Expander Element

## License

MIT
