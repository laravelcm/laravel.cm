<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | This is the storage disk Markdown Editor will use to store files. You may use
    | any of the disks defined in the `config/filesystems.php`.
    |
    */

    'disk' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Syntax Highlighting Theme
    |--------------------------------------------------------------------------
    |
    | The Shiki theme to use for syntax highlighting in code blocks.
    | Available themes: https://github.com/shikijs/textmate-grammars-themes/tree/main/packages/tm-themes
    |
    | Popular options: github-dark, github-light, monokai, nord, one-dark-pro, dracula
    |
    */

    'theme' => env('MARKDOWN_EDITOR_THEME', 'github-light'),
];
