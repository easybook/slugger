<?php

/*
 * This file is part of the easybook slugger library.
 *
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Easybook\Tests;

class SeoSluggerTest extends BaseSluggerTest
{
    public function setUp()
    {
        $this->sluggerClassName = 'SeoSlugger';

        parent::setUp();
    }

    public function provideSlugFileNames()
    {
        return array(
            array('strings.txt'),
        );
    }
}