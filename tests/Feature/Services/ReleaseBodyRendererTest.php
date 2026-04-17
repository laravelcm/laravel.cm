<?php

declare(strict_types=1);

use App\Services\ReleaseBodyRenderer;

describe(ReleaseBodyRenderer::class, function (): void {
    beforeEach(function (): void {
        $this->renderer = new ReleaseBodyRenderer('https://github.com/laravelcm/laravel.cm');
    });

    it('renders markdown to html', function (): void {
        $html = $this->renderer->render('## Heading');

        expect($html)->toContain('<h2>')
            ->and($html)->toContain('Heading');
    });

    it('strips javascript url scheme from links', function (): void {
        $html = $this->renderer->render('[click](javascript:alert(1))');

        expect($html)->not->toContain('javascript:');
    });

    it('strips data and vbscript url schemes from links', function (): void {
        $html = $this->renderer->render(
            '[a](data:text/html,<script>alert(1)</script>) and [b](vbscript:msg)'
        );

        expect($html)
            ->not->toContain('data:text/html')
            ->and($html)->not->toContain('vbscript:');
    });

    it('adds target, noopener, noreferrer and nofollow on external https links', function (): void {
        $html = $this->renderer->render('Visit [laravel.cm](https://laravel.cm)');

        expect($html)
            ->toContain('target="_blank"')
            ->and($html)->toContain('noopener')
            ->and($html)->toContain('noreferrer')
            ->and($html)->toContain('nofollow');
    });

    it('does not modify relative anchors', function (): void {
        $html = $this->renderer->render('[jump](#section)');

        expect($html)->not->toContain('target="_blank"');
    });

    it('linkifies pull request references', function (): void {
        $html = $this->renderer->render('Shipped in #527.');

        expect($html)
            ->toContain('href="https://github.com/laravelcm/laravel.cm/pull/527"')
            ->and($html)->toContain('>#527</a>');
    });

    it('does not double-wrap anchors when both a link and a pr reference are present', function (): void {
        $html = $this->renderer->render('See [docs](https://laravel.cm/docs) and #527.');

        expect(mb_substr_count($html, 'target="_blank"'))->toBe(2)
            ->and(mb_substr_count($html, 'noreferrer'))->toBe(2);
    });

    it('uses the configured repository url for pr references', function (): void {
        $customRenderer = new ReleaseBodyRenderer('https://github.com/custom/repo');

        $html = $customRenderer->render('See #42.');

        expect($html)->toContain('https://github.com/custom/repo/pull/42');
    });
});
