<?php

namespace App\Markdown;

use Illuminate\Support\ServiceProvider;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\Mention\MentionExtension;
use Torchlight\Commonmark\V1\TorchlightExtension;

class MarkdownServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(Converter::class, function () {
            $environment = Environment::createCommonMarkEnvironment();

            $environment->addExtension(new MentionExtension)
                ->addExtension(new TorchlightExtension());

            $environment->mergeConfig([
                'mentions' => [
                    'username' => [
                        'prefix' => '@',
                        'pattern' => '[a-z\d](?:[a-z\d]|-(?=[a-z\d])){0,38}(?!\w)',
                        'generator' => config('app.url') . '/user/%s',
                    ],
                ],
            ]);

            return new LeagueConverter(new CommonMarkConverter(['html_input' => 'escape'], $environment));
        });
    }
}
