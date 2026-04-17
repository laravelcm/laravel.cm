<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

describe('safe_previous_url', function (): void {
    beforeEach(function (): void {
        config(['app.url' => 'https://laravel.cm']);
    });

    it('returns the previous url when it is same-origin', function (): void {
        URL::getRequest()->headers->set('referer', 'https://laravel.cm/articles');

        expect(safe_previous_url())->toBe('https://laravel.cm/articles');
    });

    it('returns the home route when the previous url is on a different host', function (): void {
        URL::getRequest()->headers->set('referer', 'https://evil.com/phishing');

        expect(safe_previous_url())->toBe(route('home'));
    });

    it('returns the home route when no previous url is available', function (): void {
        $request = Request::create('/current-page', 'GET');
        app()->instance('request', $request);
        URL::setRequest($request);

        expect(safe_previous_url())->toBe(route('home'));
    });

    it('returns a provided fallback instead of home when the previous url is off-site', function (): void {
        URL::getRequest()->headers->set('referer', 'https://evil.com/attack');

        expect(safe_previous_url('https://laravel.cm/fallback'))->toBe('https://laravel.cm/fallback');
    });

    it('does not leak if the previous url is malformed', function (): void {
        URL::getRequest()->headers->set('referer', '///no-host-here');

        expect(safe_previous_url())->toBe(route('home'));
    });

    it('rejects previous urls that share a suffix with the app host', function (): void {
        URL::getRequest()->headers->set('referer', 'https://fake-laravel.cm/');

        expect(safe_previous_url())->toBe(route('home'));
    });
});
