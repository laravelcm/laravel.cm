<?php

declare(strict_types=1);

namespace App\Markdown;

final class MarkdownHelper
{
    public static function parseLiquidTags(string $html): string
    {
        $matches = [];

        // If we find at least one liquid tag
        if (preg_match_all('/{% .* %}/', $html, $matches) && $matches[0]) {
            // loop through each of the liquid tags
            foreach ($matches[0] as $index => $match) {
                // replace multiple spaces with single space
                $matchArray = explode(' ', preg_replace('!\s+!', ' ', $match));

                // gaurantee we have the first value and run specific function for specific tag
                if ($matchArray[1]) {
                    switch ($matchArray[1]) {
                        case 'youtube':
                            $html = self::replaceYouTubeTag($html, $matchArray, $match);

                            break;
                        case 'codepen':
                            $html = self::replaceCodePenTag($html, $matchArray, $match);

                            break;
                        case 'codesandbox':
                            $html = self::replaceCodeSandboxTag($html, $matchArray, $match);

                            break;
                        case 'buymeacoffee':
                            $html = self::replaceBuyMeACoffeeTag($html, $matchArray, $match);

                            break;
                        case 'giphy':
                            $html = self::replaceGiphyTag($html, $matchArray, $match);

                            break;
                    }
                }
            }
        }

        return $html;
    }

    /**
     * @param  string[]  $tagArray
     */
    public static function replaceYouTubeTag(string $html, array $tagArray, string $original_string): string
    {
        if (isset($tagArray[2])) {
            $youtubeEmbedURL = $tagArray[2];
            $youtubeEmbed = '<div class="overflow-hidden rounded-lg"><iframe width="100%" height="399" src="https://www.youtube.com/embed/'.$youtubeEmbedURL.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>';
            $html = str_replace($original_string, $youtubeEmbed, $html);
        }

        return $html;
    }

    /**
     * @param  string[]  $tagArray
     */
    public static function replaceCodePenTag(string $html, array $tagArray, string $original_string): string
    {
        if (isset($tagArray[2])) {
            $codepenEmbedURL = str_replace('/pen/', '/embed/', $tagArray[2]);
            $defaultTag = 'default-tab=result';
            if (isset($tagArray[3]) && $tagArray[3] !== '%}') {
                $defaultTag = $tagArray[3];
            }
            $codepenEmbed = '<div class="overflow-hidden border border-skin-light rounded-lg"><iframe loading="lazy" height="600" style="width: 100%;" scrolling="no" src="'.$codepenEmbedURL.'?height=600&theme-id=24057&'.$defaultTag.'" frameborder="no" allowtransparency="true" allowfullscreen="true"></iframe></div>';
            $html = str_replace($original_string, $codepenEmbed, $html);
        }

        return $html;
    }

    /**
     * @param  array<string, mixed>  $tagArray
     */
    public static function replaceCodeSandboxTag(string $html, array $tagArray, string $original_string): string
    {
        if (isset($tagArray[2]) && $tagArray[2] !== '%}') {
            $codesandbox = $tagArray[2];
            $url = parse_url($codesandbox);
            // @phpstan-ignore-next-line
            if (filter_var($codesandbox, FILTER_VALIDATE_URL) && ($url['host'] === 'www.codesandbox.io' || $url['host'] === 'codesandbox.io')) {
                $codesandboxEmbed = '<iframe src="'.$codesandbox.'" style="width:100%; height:500px; border:0; border-radius: 4px; overflow:hidden;" title="rough-field-mykn0" allow="accelerometer; ambient-light-sensor; camera; encrypted-media; geolocation; gyroscope; hid; microphone; midi; payment; usb; vr; xr-spatial-tracking" sandbox="allow-forms allow-modals allow-popups allow-presentation allow-same-origin allow-scripts"></iframe>';
                $html = str_replace($original_string, $codesandboxEmbed, $html);
            }
        }

        return $html;
    }

    /**
     * @param  string[]  $tagArray
     */
    public static function replaceBuyMeACoffeeTag(string $html, array $tagArray, string $original_string): string
    {
        if (isset($tagArray[2]) && $tagArray[2] !== '%}') {
            $buyMeACoffee = $tagArray[2];
            $bmcEmbed = '<div class="text-center"><a href="https://buymeacoffee.com/'.$buyMeACoffee.'"><img style="max-height: 90px;" src="https://cdn.devdojo.com/assets/img/buymeacoffee.png" alt="Buy Me A Coffee '.$buyMeACoffee.'"></a></div>';
            $html = str_replace($original_string, $bmcEmbed, $html);
        }

        return $html;
    }

    /**
     * @param  string[]  $tagArray
     */
    public static function replaceGiphyTag(string $html, array $tagArray, string $original_string): string
    {
        if (isset($tagArray[2])) {
            $giphyEmbed = $tagArray[2];
            $giphyEmbed = '<div style="width:100%;height:0;padding-bottom:56%;position:relative;display:block"><iframe src="'.$giphyEmbed.'" width="100%" height="100%" style="position:absolute" frameBorder="0" class="giphy-embed" allowFullScreen></iframe></p></div>';
            $html = str_replace($original_string, $giphyEmbed, $html);
        }

        return $html;
    }
}
