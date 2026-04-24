<?php

declare(strict_types=1);

namespace App\Markdown;

use HTMLPurifier;
use HTMLPurifier_Config;

final class MarkdownSanitizer
{
    private const array ALLOWED_URI_SCHEMES = [
        'http' => true,
        'https' => true,
        'mailto' => true,
    ];

    private const string ALLOWED_HTML = 'p,a[href|title|rel|target],'
        .'ul,ol,li,strong,b,em,i,u,sub,sup,'
        .'code[class],pre[class],'
        .'blockquote,h1,h2,h3,h4,h5,h6,'
        .'table,thead,tbody,tr,td[align|colspan|rowspan],th[align|colspan|rowspan|scope],'
        .'img[src|alt|title|width|height|class],br,hr,'
        .'div[class],span[class]';

    private ?HTMLPurifier $purifier = null;

    public function purify(string $html): string
    {
        return $this->purifier()->purify($html);
    }

    private function purifier(): HTMLPurifier
    {
        if ($this->purifier instanceof HTMLPurifier) {
            return $this->purifier;
        }

        $config = HTMLPurifier_Config::createDefault();

        $config->set('Cache.SerializerPath', $this->cacheDir());
        $config->set('HTML.Allowed', self::ALLOWED_HTML);
        $config->set('HTML.ForbiddenElements', ['script', 'style', 'iframe', 'object', 'embed', 'form', 'input', 'button', 'textarea', 'select', 'option', 'meta', 'link', 'base']);
        $config->set('HTML.ForbiddenAttributes', [
            '*@on*',
            '*@formaction',
            '*@srcdoc',
            'a@download',
            'a@ping',
        ]);
        $config->set('HTML.SafeIframe', false);
        $config->set('HTML.SafeObject', false);
        $config->set('HTML.Nofollow', true);
        $config->set('HTML.TargetBlank', true);
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('URI.AllowedSchemes', self::ALLOWED_URI_SCHEMES);
        $config->set('URI.DisableExternalResources', false);
        $config->set('URI.Munge', null);
        $config->set('Core.Encoding', 'UTF-8');
        $config->set('Core.EscapeInvalidTags', false);
        $config->set('Output.Newline', "\n");
        $config->set('AutoFormat.AutoParagraph', false);
        $config->set('AutoFormat.RemoveEmpty', false);

        return $this->purifier = new HTMLPurifier($config);
    }

    private function cacheDir(): string
    {
        $path = storage_path('framework/cache/htmlpurifier');

        if (! is_dir($path)) {
            mkdir(directory: $path, permissions: 0755, recursive: true);
        }

        return $path;
    }
}
