<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('ckeditor_to_tailwind')) {
    function ckeditor_to_tailwind($html)
    {
        $html = str_replace('[removed]', '', $html);
        $html = mb_convert_encoding('<div>' . $html . '</div>', 'HTML-ENTITIES', 'UTF-8');

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $xpath = new DOMXPath($dom);

        $addClass = function ($el, $class) {
            $existing = $el->getAttribute('class');
            $el->setAttribute('class', trim("$existing $class"));
        };

        // Typography
        foreach ($xpath->query('//p') as $el) $addClass($el, 'mb-4');
        foreach ($xpath->query('//h1') as $el) $addClass($el, 'text-4xl font-bold mb-4');
        foreach ($xpath->query('//h2') as $el) $addClass($el, 'text-3xl font-semibold mb-4');
        foreach ($xpath->query('//h3') as $el) $addClass($el, 'text-2xl font-semibold mb-3');
        foreach ($xpath->query('//h4') as $el) $addClass($el, 'text-xl font-medium mb-2');
        foreach ($xpath->query('//h5') as $el) $addClass($el, 'text-lg font-medium mb-1');
        foreach ($xpath->query('//h6') as $el) $addClass($el, 'text-base font-medium mb-1');

        // Lists
        foreach ($xpath->query('//ul') as $el) $addClass($el, 'list-disc ml-5 mb-4');
        foreach ($xpath->query('//ol') as $el) $addClass($el, 'list-decimal ml-5 mb-4');
        foreach ($xpath->query('//li') as $el) $addClass($el, 'mb-1');

        // Blockquote
        foreach ($xpath->query('//blockquote') as $el) {
            $addClass($el, 'border-l-4 border-gray-300 pl-4 italic text-gray-600 mb-4');
        }

        // Inline elements
        foreach ($xpath->query('//strong') as $el) $addClass($el, 'font-bold');
        foreach ($xpath->query('//em') as $el) $addClass($el, 'italic');
        foreach ($xpath->query('//u') as $el) $addClass($el, 'underline');
        foreach ($xpath->query('//s') as $el) $addClass($el, 'line-through');
        foreach ($xpath->query('//code') as $el) $addClass($el, 'bg-gray-100 px-1 rounded text-sm font-mono');

        // Link
        foreach ($xpath->query('//a') as $el) {
            $addClass($el, 'text-blue-600 underline hover:text-blue-800');
            if (!$el->hasAttribute('target')) {
                $el->setAttribute('target', '_blank');
                $el->setAttribute('rel', 'noopener noreferrer');
            }
        }

        // Media
        foreach ($xpath->query('//img') as $el) $addClass($el, 'max-w-full h-auto rounded my-4');
        foreach ($xpath->query('//iframe') as $el) $addClass($el, 'w-full aspect-video my-6');

        // Tables
        foreach ($xpath->query('//table') as $el) $addClass($el, 'w-full border-collapse mb-4');
        foreach ($xpath->query('//th') as $el) $addClass($el, 'border px-4 py-2 bg-gray-100 text-left');
        foreach ($xpath->query('//td') as $el) $addClass($el, 'border px-4 py-2');

        // Pre/code block
        foreach ($xpath->query('//pre') as $el) $addClass($el, 'bg-gray-100 p-4 rounded mb-4 overflow-x-auto font-mono text-sm');

        // Alignment
        foreach ($xpath->query('//*[@class[contains(., "align-left")]]') as $el) $addClass($el, 'text-left');
        foreach ($xpath->query('//*[@class[contains(., "align-center")]]') as $el) $addClass($el, 'text-center');
        foreach ($xpath->query('//*[@class[contains(., "align-right")]]') as $el) $addClass($el, 'text-right');
        foreach ($xpath->query('//*[@class[contains(., "align-justify")]]') as $el) $addClass($el, 'text-justify');

        // Font size (detect inline class)
        foreach ($xpath->query('//*[@class[contains(., "font-small")]]') as $el) $addClass($el, 'text-sm');
        foreach ($xpath->query('//*[@class[contains(., "font-large")]]') as $el) $addClass($el, 'text-lg');
        foreach ($xpath->query('//*[@class[contains(., "font-huge")]]') as $el) $addClass($el, 'text-2xl');

        // Subscript / Superscript
        foreach ($xpath->query('//*[@class[contains(., "sub")]]') as $el) $addClass($el, 'align-sub');
        foreach ($xpath->query('//*[@class[contains(., "super")]]') as $el) $addClass($el, 'align-super');

        // Color (basic regex to detect inline style or class)
        foreach ($xpath->query('//*[@style]') as $el) {
            $style = $el->getAttribute('style');
            if (stripos($style, 'color') !== false) {
                $addClass($el, 'text-current'); // kamu bisa map lebih detail jika butuh
            }
            if (stripos($style, 'background-color') !== false) {
                $addClass($el, 'bg-current'); // bisa juga dibuat map lebih kompleks
            }
        }

        $result = $dom->saveHTML($dom->documentElement);
        return str_replace(["\xc2\xa0", '&nbsp;'], ' ', $result);
    }
}
