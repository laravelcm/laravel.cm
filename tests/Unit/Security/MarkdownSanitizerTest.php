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

it('preserves torchlight code blocks intact when using purifyPreservingCodeBlocks', function (): void {
    $torchlight = '<pre><code class="torchlight" style="background-color: #292d3e;">'
        .'<div class="line"><span class="line-number" style="color: #676e95;">1</span>'
        .'<span style="color: #c792ea;">"scripts"</span>'
        .'<span style="color: #89ddff;">: {</span></div>'
        .'</code></pre>';

    $html = '<p>Before</p>'.$torchlight.'<p>After</p>';

    $purified = $this->sanitizer->purifyPreservingCodeBlocks($html);

    expect($purified)
        ->toContain($torchlight)
        ->toContain('<p>Before</p>')
        ->toContain('<p>After</p>')
        ->toContain('background-color: #292d3e')
        ->toContain('color: #c792ea');
});

it('preserves torchlight blocks with dual themes (multiple <code> nodes)', function (): void {
    $torchlight = '<pre>'
        .'<code class="torchlight dark" style="background-color: #1f1f1f;">'
        .'<div class="line"><span style="color: #fff;">dark</span></div>'
        .'</code>'
        .'<code class="torchlight light" style="background-color: #fff;">'
        .'<div class="line"><span style="color: #000;">light</span></div>'
        .'</code>'
        .'</pre>';

    $purified = $this->sanitizer->purifyPreservingCodeBlocks($torchlight);

    expect($purified)
        ->toContain('class="torchlight dark"')
        ->toContain('class="torchlight light"')
        ->toContain('background-color: #1f1f1f')
        ->toContain('background-color: #fff');
});

it('preserves multiple torchlight blocks in the same document', function (): void {
    $first = '<pre><code class="torchlight" style="color:#aaa;"><div class="line">A</div></code></pre>';
    $second = '<pre><code class="torchlight" style="color:#bbb;"><div class="line">B</div></code></pre>';

    $purified = $this->sanitizer->purifyPreservingCodeBlocks(
        '<p>one</p>'.$first.'<p>two</p>'.$second.'<p>three</p>'
    );

    expect($purified)
        ->toContain($first)
        ->toContain($second)
        ->toContain('<p>one</p>')
        ->toContain('<p>three</p>');
});

it('still sanitizes content around preserved torchlight blocks', function (): void {
    $torchlight = '<pre><code class="torchlight"><div class="line">safe</div></code></pre>';

    $html = '<p>before</p><script>alert(1)</script>'.$torchlight.'<img src="x" onerror="alert(2)" />';

    $purified = $this->sanitizer->purifyPreservingCodeBlocks($html);

    expect($purified)
        ->toContain($torchlight)
        ->not->toContain('<script>')
        ->not->toContain('alert(1)')
        ->not->toContain('onerror')
        ->not->toContain('alert(2)');
});

it('does not preserve a non-torchlight pre block (still goes through sanitizer)', function (): void {
    $html = '<pre><code class="hljs"><span style="color: red" onclick="alert(1)">evil</span></code></pre>';

    $purified = $this->sanitizer->purifyPreservingCodeBlocks($html);

    expect($purified)
        ->not->toContain('onclick')
        ->not->toContain('alert(1)')
        ->not->toContain('style="color: red"')
        ->toContain('evil');
});
