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
 * Represents the interface that all sluggers must implement.
 */
interface SluggerInterface
{
    /**
     * Returns the slug corresponding to the given string and separator.
     *
     * <code>
     * $slugger = new \Easybook\Slugger();
     * $slug = $slugger->slugify('Lorem Ipsum');
     * // $slug is 'lorem-ipsum'
     * </code>
     *
     * @param  string $string    The string to transform into a slug
     * @param  string $separator The character/string used to separate slug words
     *
     * @return string            The slug that represents the string
     */
    public function slugify($string, $separator = null);

    /**
     * Returns the slug corresponding to the given string and separator and
     * ensures its uniqueness by appending a random suffix.
     *
     * <code>
     * $slugger = new \Easybook\Slugger();
     * $slug = $slugger->uniqueSlugify('Lorem Ipsum');
     * // $slug is 'lorem-ipsum-a3f672b' (the 7-character suffix is random)
     * </code>
     *
     * @param  string $string    The string to transform into a slug
     * @param  string $separator The character/string used to separate slug words
     *
     * @return string            The unique slug that represents the string
     */
    public function uniqueSlugify($string, $separator = null);
}