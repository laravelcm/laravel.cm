<?php

declare(strict_types=1);

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Http;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use SimpleXMLElement;

final class FetchRssFeed implements Tool
{
    private const int MAX_ITEMS = 20;

    private const int MAX_DESCRIPTION_LENGTH = 300;

    public function description(): string
    {
        return 'Fetch and parse an RSS or Atom feed URL. Returns a structured list of recent items with their title, link, date and description. Use this for each source URL.';
    }

    public function handle(Request $request): string
    {
        $url = (string) $request->string('url');

        $response = Http::timeout(15)
            ->withHeaders([
                'User-Agent' => 'LaravelCM-News/1.0',
                'Accept' => 'application/rss+xml, application/xml, text/xml, */*',
            ])
            ->get($url);

        if ($response->failed()) {
            return sprintf('ERREUR: Impossible de charger %s (HTTP %d)', $url, $response->status());
        }

        libxml_use_internal_errors(true);
        $feed = simplexml_load_string($response->body());

        if ($feed === false) {
            return 'ERREUR: XML invalide depuis '.$url;
        }

        $items = $this->extractItems($feed);

        if (blank($items)) {
            return 'VIDE: Aucun item trouvé dans le flux '.$url;
        }

        $output = sprintf('SOURCE: %s%s', $url, PHP_EOL);
        $output .= 'ITEMS: '.count($items)."\n\n";

        return $output.implode("\n---\n", $items);
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'url' => $schema->string()
                ->description('The RSS or Atom feed URL to fetch')
                ->required(),
        ];
    }

    /**
     * @return list<string>
     */
    private function extractItems(SimpleXMLElement $feed): array
    {
        $items = [];

        // RSS 2.0 format
        if (property_exists($feed->channel, 'item') && $feed->channel->item !== null) {
            foreach ($feed->channel->item as $item) {
                if (count($items) >= self::MAX_ITEMS) {
                    break;
                }

                $items[] = $this->formatItem(
                    title: (string) ($item->title ?? ''),
                    link: (string) ($item->link ?? ''),
                    date: (string) ($item->pubDate ?? ''),
                    description: (string) ($item->description ?? ''),
                );
            }
        }

        // Atom format
        if (property_exists($feed, 'entry') && $feed->entry !== null) {
            foreach ($feed->entry as $entry) {
                if (count($items) >= self::MAX_ITEMS) {
                    break;
                }

                $link = '';
                if (property_exists($entry, 'link') && $entry->link !== null) {
                    $link = (string) ($entry->link['href'] ?? $entry->link);
                }

                $items[] = $this->formatItem(
                    title: (string) ($entry->title ?? ''),
                    link: $link,
                    date: (string) ($entry->published ?? $entry->updated ?? ''),
                    description: (string) ($entry->summary ?? $entry->content ?? ''),
                );
            }
        }

        return $items;
    }

    private function formatItem(string $title, string $link, string $date, string $description): string
    {
        $description = strip_tags($description);
        $description = (string) preg_replace('/\s+/', ' ', $description);
        $description = mb_substr(mb_trim($description), 0, self::MAX_DESCRIPTION_LENGTH);

        $parts = [];

        if ($title !== '') {
            $parts[] = 'TITRE: '.$title;
        }

        if ($link !== '') {
            $parts[] = 'LIEN: '.$link;
        }

        if ($date !== '') {
            $parts[] = 'DATE: '.$date;
        }

        if ($description !== '') {
            $parts[] = 'RESUME: '.$description;
        }

        return implode("\n", $parts);
    }
}
