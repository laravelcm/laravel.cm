<?php

declare(strict_types=1);

use Laravelcm\LivewireSlideOvers\Position;

return [

    /*
    |--------------------------------------------------------------------------
    | Include CSS
    |--------------------------------------------------------------------------
    |
    | The Slide over uses TailwindCSS, if you don't use TailwindCSS you will need
    | to set this parameter to true. This includes the modern-normalize css.
    |
    */
    'include_css' => false,

    /*
    |--------------------------------------------------------------------------
    | Include JS
    |--------------------------------------------------------------------------
    |
    | Livewire Slide Overs will inject the required Javascript in your blade template.
    | If you want to bundle the required Javascript you can set this to false
    | and add `require('vendor/laravelcm/livewire-slide-overs/resources/js/slide-over');`
    | to your script bundler like webpack.
    |
    */
    'include_js' => false,

    /*
    |--------------------------------------------------------------------------
    | Slide Over Position
    |--------------------------------------------------------------------------
    |
    | Configure which side the slide-over will open from.
    |
    | Supported: Position::Right, Position::Left
    |
    */
    'position' => Position::Right,

    /*
    |--------------------------------------------------------------------------
    | Stacked Panels
    |--------------------------------------------------------------------------
    |
    | When enabled, opening a new panel while one is already open will visually
    | stack them: previous panels remain visible but scale down and shift aside,
    | creating a depth effect. When disabled (default), only the active panel
    | is visible and previous panels are hidden.
    |
    */
    'stack' => true,

    /*
    |--------------------------------------------------------------------------
    | Slide Over Component Defaults
    |--------------------------------------------------------------------------
    |
    | Configure the default properties for a slide-over component.
    |
    | Supported slide_over_max_width
    | 'sm', 'md', 'lg', 'xl', '2xl', '3xl', '4xl', '5xl', '6xl', '7xl'
    |
    */
    'component_defaults' => [
        'slide_over_max_width' => 'xl',
        'close_slide_over_on_click_away' => true,
        'close_slide_over_on_escape' => true,
        'close_slide_over_on_escape_is_forceful' => true,
        'dispatch_close_event' => false,
        'destroy_on_close' => false,
    ],

];
