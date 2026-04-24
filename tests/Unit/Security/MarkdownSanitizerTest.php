<?php

declare(strict_types=1);

use App\Markdown\MarkdownSanitizer;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    $this->sanitizer = new MarkdownSanitizer;
});

it('strips script tags', function (): void {
    $html = '<p>Hello</p><script>alert(1)</script>';

    expect($this->sanitizer->purify($html))
        ->toContain('<p>Hello</p>')
        ->not->toContain('<script>')
        ->not->toContain('alert(1)');
});

it('strips iframe tags even from trusted sources', function (): void {
    $html = '<iframe src="https://evil.tld"></iframe>';

    expect($this->sanitizer->purify($html))
        ->not->toContain('<iframe');
});

it('strips onerror and onload attributes', function (): void {
    $html = '<img src="x" onerror="alert(1)" />';

    expect($this->sanitizer->purify($html))
        ->not->toContain('onerror')
        ->not->toContain('alert(1)');
});

it('strips javascript: URLs from anchor href', function (): void {
    $html = '<a href="javascript:alert(1)">click</a>';

    expect($this->sanitizer->purify($html))
        ->not->toContain('javascript:');
});

it('strips data:text/html URIs from anchor href', function (): void {
    $html = '<a href="data:text/html,<script>alert(1)</script>">click</a>';

    expect($this->sanitizer->purify($html))
        ->not->toContain('data:text/html')
        ->not->toContain('<script>');
});

it('adds rel=nofollow and target=_blank to external links', function (): void {
    $html = '<a href="https://example.com">click</a>';

    $purified = $this->sanitizer->purify($html);

    expect($purified)
        ->toContain('href="https://example.com"')
        ->toContain('nofollow')
        ->toContain('noopener')
        ->toContain('target="_blank"');
});

it('keeps safe markdown-generated html intact', function (): void {
    $html = '<h2>Title</h2><p>Body with <strong>strong</strong> and <em>em</em> and <code>code</code>.</p><ul><li>item</li></ul>';

    $purified = $this->sanitizer->purify($html);

    expect($purified)
        ->toContain('<h2>Title</h2>')
        ->toContain('<strong>strong</strong>')
        ->toContain('<em>em</em>')
        ->toContain('<code>code</code>')
        ->toContain('<li>item</li>');
});

it('strips form and input elements', function (): void {
    $html = '<form action="https://evil.tld"><input type="text" name="creds" /><button>Submit</button></form>';

    $purified = $this->sanitizer->purify($html);

    expect($purified)
        ->not->toContain('<form')
        ->not->toContain('<input')
        ->not->toContain('<button');
});

it('strips object and embed tags', function (): void {
    $html = '<object data="evil.swf"></object><embed src="evil.swf" />';

    expect($this->sanitizer->purify($html))
        ->not->toContain('<object')
        ->not->toContain('<embed');
});
