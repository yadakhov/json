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

    public function testPassingNullToConstructor()
    {
        $json = new Json(null);
        $this->assertEquals('null', $json->toString());
    }

    public function testPassingBooleanConstructor()
    {
        $json = new Json(true);
        $this->assertEquals('true', $json->toString());
        $json = new Json(false);
        $this->assertEquals('false', $json->toString());
    }

    public function testPassingStringToConstructor()
    {
        $json = new Json('foo');
        $this->assertEquals('"foo"', $json->toString());
        $json = new Json('{}');
        $this->assertEquals('"{}"', $json->toString());
        $json = new Json('[1,5,"false"]');
        $this->assertEquals('[1,5,"false"]', $json->toString());
    }

    public function testPassingArrayToConstructor()
    {
        $json = new Json(['name' => 'yada']);
        $this->assertEquals('{"name":"yada"}', $json->toString());

        $json = new Json([1, 5, "false"]);
        $this->assertEquals('[1,5,"false"]', $json->toString());
    }


}
