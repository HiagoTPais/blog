<?php

namespace App\Services;

use Illuminate\Support\Str;

class MarkdownService
{
    public function normalizeForStorage(string $markdown): string
    {
        $markdown = str_replace(["\r\n", "\r"], "\n", $markdown);

        return trim($markdown);
    }

    public function toHtml(string $markdown): string
    {
        $html = Str::markdown($this->normalizeForStorage($markdown), [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return preg_replace_callback(
            '/<h([1-6])>(.*?)<\/h\1>/s',
            function (array $matches): string {
                $id = Str::slug(strip_tags($matches[2]));

                return "<h{$matches[1]} id=\"{$id}\">{$matches[2]}</h{$matches[1]}>";
            },
            $html
        ) ?? $html;
    }

    public function extractHeadings(string $markdown): array
    {
        $headings = [];
        $lines = explode("\n", $this->normalizeForStorage($markdown));

        foreach ($lines as $line) {
            if (preg_match('/^(#{1,6})\s+(.+)$/', trim($line), $matches)) {
                $level = strlen($matches[1]);
                $text = trim($matches[2]);
                $id = Str::slug($text);

                $headings[] = [
                    'level' => $level,
                    'text' => $text,
                    'id' => $id,
                ];
            }
        }

        return $headings;
    }

    public function wordCount(string $markdown): int
    {
        $plain = $this->normalizeForStorage($markdown);
        $plain = preg_replace('/```[\s\S]*?```/', ' ', $plain) ?? $plain;
        $plain = preg_replace('/`[^`]+`/', ' ', $plain) ?? $plain;
        $plain = preg_replace('/[#>*_\[\]()!|~-]/', ' ', $plain) ?? $plain;
        $plain = strip_tags($plain);

        return str_word_count($plain);
    }
}
