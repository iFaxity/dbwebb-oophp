<?php

namespace Faxity\TextFilterer;

use \Michelf\Markdown;

/**
 * Class for multiple text filters to use in the CMS
 */
class TextFilter
{
    const LINK_REGEX = '#\b(?<![href|src]=[\'"])https?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#';
    const BBCODE_REGEX = [
        '/\[b\](.*?)\[\/b\]/is',
        '/\[i\](.*?)\[\/i\]/is',
        '/\[u\](.*?)\[\/u\]/is',
        '/\[img\](https?.*?)\[\/img\]/is',
        '/\[url\](https?.*?)\[\/url\]/is',
        '/\[url=(https?.*?)\](.*?)\[\/url\]/is'
    ];
    const BBCODE_REGEX_REPLACE = [
        '<strong>$1</strong>',
        '<em>$1</em>',
        '<u>$1</u>',
        '<img src="$1" />',
        '<a href="$1">$1</a>',
        '<a href="$1">$2</a>'
    ];


    /**
     * Filter to convert BBCode formatting to valid HTML.
     *
     * @param string $content The text to be converted.
     * @param string $filter.
     * @return string The formatted html.
     */
    public function parse($content, $filter) : string
    {
        foreach ($filter as $name) {
            $name = trim($name);

            if (!method_exists($this, $name)) {
                throw new \Exception("Filter '{$name}' doesn't exist.");
            }

            $content = $this->{$name}($content);
        }

        return $content;
    }

    /**
     * Filter to convert BBCode formatting to valid HTML.
     *
     * @param string $content The text to be converted.
     * @return string The formatted html.
     */
    public function bbcode($content) : string
    {
        return preg_replace(self::BBCODE_REGEX, self::BBCODE_REGEX_REPLACE, $content);
    }


    /**
     * Filter to convert BBCode formatting to valid HTML.
     *
     * @param string $content The text to be converted.
     * @return string The formatted html.
     */
    public function link($content) : string
    {
        return preg_replace_callback(self::LINK_REGEX, function ($match) {
            return "<a href=\"{$match[0]}\">{$match[0]}</a>";
        }, $content);
    }


    /**
     * Filter to convert BBCode formatting to valid HTML.
     *
     * @param string $content The text to be converted.
     * @return string The formatted html.
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function markdown($content) : string
    {
        return Markdown::defaultTransform($content);
    }


    /**
     * Filter to convert BBCode formatting to valid HTML.
     *
     * @param string $content The text to be converted.
     * @return string The formatted html.
     */
    public function nl2br($content) : string
    {
        return nl2br($content, false);
    }


    /**
     * Filter to convert BBCode formatting to valid HTML.
     *
     * @param string $content The text to be converted.
     * @return string The formatted html.
     */
    public function strip($content) : string
    {
        return strip_tags($content);
    }


    /**
     * Filter to convert BBCode formatting to valid HTML.
     *
     * @param string $content The text to be converted.
     * @return string The formatted html.
     */
    public function esc($content) : string
    {
        return htmlentities($content);
    }
}
