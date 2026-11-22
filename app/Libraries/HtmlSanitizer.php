<?php

namespace App\Libraries;

use RuntimeException;

/**
 * Sanitasi HTML sederhana dengan daftar tag dan atribut yang diizinkan.
 */
class HtmlSanitizer
{
    private const ALLOWED = [
        'p'          => [],
        'br'         => [],
        'strong'     => [],
        'b'          => [],
        'em'         => [],
        'i'          => [],
        'u'          => [],
        'ul'         => [],
        'ol'         => [],
        'li'         => [],
        'h2'         => [],
        'h3'         => [],
        'h4'         => [],
        'blockquote' => [],
        'a'          => ['href', 'title', 'target', 'rel'],
        'img'        => ['src', 'alt', 'width', 'height'],
    ];

    public static function clean(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        $document = new \DOMDocument('1.0', 'UTF-8');
        $previous = libxml_use_internal_errors(true);
        $loaded   = $document->loadHTML(
            '<?xml encoding="UTF-8"><div id="sanitizer-root">' . $html . '</div>',
            LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
        );
        libxml_clear_errors();
        libxml_use_internal_errors($previous);

        if (! $loaded) {
            throw new RuntimeException('Konten HTML tidak dapat diproses.');
        }

        $root = $document->getElementById('sanitizer-root');
        if ($root === null) {
            return '';
        }

        return self::renderChildren($root);
    }

    private static function renderChildren(\DOMNode $node): string
    {
        $output = '';

        foreach ($node->childNodes as $child) {
            if ($child instanceof \DOMText) {
                $output .= htmlspecialchars($child->nodeValue ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
                continue;
            }

            if (! $child instanceof \DOMElement) {
                continue;
            }

            $tag = strtolower($child->tagName);
            if (! array_key_exists($tag, self::ALLOWED)) {
                // Tag tidak diizinkan: pertahankan isi teksnya saja.
                $output .= self::renderChildren($child);
                continue;
            }

            $attributes = '';
            foreach (self::ALLOWED[$tag] as $attribute) {
                if (! $child->hasAttribute($attribute)) {
                    continue;
                }

                $value = trim($child->getAttribute($attribute));
                if ($value === '') {
                    continue;
                }

                if (in_array($attribute, ['href', 'src'], true) && ! self::isSafeUrl($value)) {
                    continue;
                }

                if ($attribute === 'target') {
                    $value = '_blank';
                }

                $attributes .= ' ' . $attribute . '="' . htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . '"';
            }

            if ($tag === 'a' && str_contains($attributes, 'target="_blank"')) {
                $attributes .= ' rel="noopener noreferrer"';
            }

            $output .= '<' . $tag . $attributes . '>' . self::renderChildren($child) . '</' . $tag . '>';
        }

        return $output;
    }

    private static function isSafeUrl(string $url): bool
    {
        $normalized = strtolower(preg_replace('/\s+/', '', $url) ?? '');

        return str_starts_with($normalized, 'http://')
            || str_starts_with($normalized, 'https://')
            || str_starts_with($normalized, 'mailto:')
            || str_starts_with($normalized, 'tel:')
            || str_starts_with($normalized, '/')
            || str_starts_with($normalized, 'uploads/')
            || str_starts_with($normalized, 'assets/');
    }
}
