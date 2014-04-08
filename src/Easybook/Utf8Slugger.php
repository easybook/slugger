<?php

/*
 * This file is part of the easybook slugger library.
 *
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Easybook;

/**
 * UTF-8-compliant slugger suitable for any alphabet (including
 * japanese, arabic and hebrew languages). If you don't need to slugify
 * strings that make use of those languages, use instead the much faster
 * Slugger class.
 */
class Utf8Slugger implements SluggerInterface
{
    private $separator;

    public function __construct($separator = null)
    {
        if (!function_exists('transliterator_transliterate')) {
            throw new \RuntimeException('Unable to use Utf8Slugger (it requires PHP >= 5.4.0 and intl >= 2.0 extension).');
        }

        $this->separator = $separator ?: '-';
    }

    /**
     * {@inheritdoc}
     */
    public function slugify($string, $separator = null)
    {
        $separator = $separator ?: $this->separator;

        $slug = trim(strip_tags($string));
        $slug = transliterator_transliterate(
            "NFD; [:Nonspacing Mark:] Remove; NFC; Any-Latin; Latin-ASCII; Lower();",
            $slug
        );
        $slug = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $slug);
        $slug = preg_replace("/[\/_|+ -]+/", $separator, $slug);
        $slug = trim($slug, $separator);

        return $slug;
    }

    /**
     * {@inheritdoc}
     */
    public function uniqueSlugify($string, $separator = null)
    {
        $separator = $separator ?: $this->separator;

        $slug = $this->slugify($string, $separator);
        $slug .= $separator.substr(md5(mt_rand()), 0, 7);

        return $slug;
    }
}