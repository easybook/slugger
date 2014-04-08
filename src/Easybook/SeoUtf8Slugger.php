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
 * japanese, arabic and hebrew languages) which also transforms
 * into words some special parts of the string, such as email
 * addresses, numbers and currencies.
 * If you don't need fancy transformations, use Utf8Slugger class.
 * If you don't need complex alphabet support, use SeoSlugger class.
 */
class SeoUtf8Slugger extends SeoSlugger implements SluggerInterface
{
    public function __construct($separator = null)
    {
        parent::__construct($separator);
    }

    /**
     * {@inheritdoc}
     */
    public function slugify($string, $separator = null)
    {
        $separator = $separator ?: $this->separator;
        $string = $this->expandString($string);

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
        $string = $this->expandString($string);

        $slug = $this->slugify($string, $separator);
        $slug .= $separator.substr(md5(mt_rand()), 0, 7);

        return $slug;
    }
}