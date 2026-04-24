<?php

declare(strict_types=1);

use App\Markdown\SuspiciousContentDetector;

uses(Tests\TestCase::class);

beforeEach(function (): void {
    $this->detector = new SuspiciousContentDetector;
});

it('does not flag legitimate content', function (): void {
    $content = "Check this out: https://laravel.com and https://github.com/laravelcm\n\nReal content here.";

    expect($this->detector->analyse($content))->toBeEmpty()
        ->and($this->detector->isSuspicious($content))->toBeFalse();
});

it('flags bit.ly shortener links', function (): void {
    expect($this->detector->isSuspicious('Click: https://bit.ly/abc123'))->toBeTrue();
});

it('flags tinyurl links', function (): void {
    expect($this->detector->isSuspicious('See https://tinyurl.com/xyz'))->toBeTrue();
});

it('flags IP-as-host URLs', function (): void {
    expect($this->detector->isSuspicious('Go to http://192.168.1.1/login'))->toBeTrue();
});

it('flags .onion hosts', function (): void {
    expect($this->detector->isSuspicious('Secret: http://abc.onion/stuff'))->toBeTrue();
});

it('flags html extension in URL', function (): void {
    expect($this->detector->isSuspicious('Read https://laravelcm.s3.fr-par.scw.cloud/public/malicious.html'))->toBeTrue();
});

it('flags exe download links', function (): void {
    expect($this->detector->isSuspicious('Download https://example.com/setup.exe'))->toBeTrue();
});

it('flags phishing keywords in path', function (): void {
    expect($this->detector->isSuspicious('Verify: https://laravel-cm.com/account-suspended/verify'))->toBeTrue()
        ->and($this->detector->isSuspicious('Reset: https://example.com/reset-password?token=abc'))->toBeTrue();
});

it('flags homograph attacks on common brands', function (): void {
    expect($this->detector->isSuspicious('Connect: https://paypa1.com/login'))->toBeTrue()
        ->and($this->detector->isSuspicious('Free gift: https://g00gle.com'))->toBeTrue();
});

it('flags more than 10 URLs', function (): void {
    $urls = collect(range(1, 12))
        ->map(fn (int $i): string => sprintf('https://site%d.com', $i))
        ->implode("\n");

    expect($this->detector->isSuspicious($urls))->toBeTrue();
});

it('returns list of reasons for reporting', function (): void {
    $reasons = $this->detector->analyse('https://bit.ly/x and https://evil.exe/foo');

    expect($reasons)->toBeArray()->not->toBeEmpty();
});
