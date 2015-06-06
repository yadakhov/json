<?php

/*
 * This file is part of the Json package.
 *
 * (c) Yada Khov <yada.khov@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Yadakhov\Json;

class JsonTest extends BootstrapTest
{

    public $name = [
        'author' =>[
            'firstName' => 'Yada',
            'lastName' => 'Khov'
        ]
    ];

    public function testArrayDot()
    {
        $expected = [
            'author.firstName' => 'Yada',
            'author.lastName' => 'Khov'
        ];

        $this->assertEquals($expected, Json::arrayDot($this->name));
    }

    public function testArrayGet()
    {
        $this->assertEquals(3, Json::arrayGet($this->name, 'randomkey', null));
    }

}
