<?php

declare(strict_types=1);

namespace App\Markdown;

use HTMLPurifier;
use HTMLPurifier_Config;
use Illuminate\Support\Facades\Log;

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

    private const string TORCHLIGHT_BLOCK_PATTERN = '#<pre>\s*<code\b[^>]*\bclass\s*=\s*[\'"][^\'"]*\btorchlight\b[^\'"]*[\'"][^>]*>.*?</pre>#is';

    private const string PLACEHOLDER_FORMAT = '___TORCHLIGHT_BLOCK_%s___';

    private ?HTMLPurifier $purifier = null;

    public function purify(string $html): string
    {
        return $this->purifier()->purify($html);
    }

    /**
     * Sanitize HTML while routing Torchlight code blocks around HTMLPurifier
     * to preserve their inline styles and syntax-highlighting markup.
     */
    public function purifyPreservingCodeBlocks(string $html): string
    {
        $blocks = [];

        $protected = preg_replace_callback(
            pattern: self::TORCHLIGHT_BLOCK_PATTERN,
            callback: function (array $match) use (&$blocks): string {
                $token = sprintf(self::PLACEHOLDER_FORMAT, hash('sha256', $match[0]));
                $blocks[$token] = $match[0];

                return $token;
            },
            subject: $html,
        );

        if (! is_string($protected)) {
            return $this->purify($html);
        }

        $purified = $this->purify($protected);

        foreach ($blocks as $token => $original) {
            $count = 0;
            $purified = str_replace($token, $original, $purified, $count);

            if ($count === 0) {
                Log::warning('Torchlight code block placeholder lost during sanitization.', [
                    'token' => $token,
                ]);
            }
        }

        return $purified;
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
