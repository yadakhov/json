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

    public function testPassingNumericToConstructor()
    {
        $json = new Json(1);
        $this->assertEquals('1', $json->toString());
        $json = new Json(-200);
        $this->assertEquals('-200', $json->toString());
        $json = new Json(3.141592);
        $this->assertEquals('3.141592', $json->toString());
        $json = new Json(-5);
        $this->assertEquals('-5', $json->toString());
    }

    public function testPassingStringToConstructor()
    {
        $json = new Json('foo');
        $this->assertEquals('"foo"', $json->toString());
        $json = new Json('{}');
        $this->assertEquals('{}', $json->toString());
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

    public function testPassingStdClassToContrutor()
    {
        $json = new Json(new stdClass());
        $this->assertEquals('{}', $json->toString());

        $obj = new stdClass();
        $obj->name = 'Yada';
        $json = new Json($obj);
        $this->assertEquals('{"name":"Yada"}', $json->toString());
    }

    public function testToArray()
    {
        $obj = new stdClass();
        $obj->name = 'Yada';
        $json = new Json($obj);

        $this->assertEquals(['name' => 'Yada'], $json->toArray());
    }

    public function testToArrayPrimitiveJson()
    {
        $json = new Json(9000);
        $this->assertEquals(9000, $json->toArray());

        $json = new Json(3.14);
        $this->assertEquals(3.14, $json->toArray());

        $json = new Json('string');
        $this->assertEquals('string', $json->toArray());

        $json = new Json(true);
        $this->assertEquals(true, $json->toArray());

        $json = new Json(null);
        $this->assertEquals(null, $json->toArray());
    }

    public function testCreateFactoryMethod()
    {
        $json = Json::create();

        $this->assertTrue($json instanceof Json);
    }

    public function testMagicGetter()
    {
        // pass by json
        $json = new Json('{"key":"value"}');
        $this->assertEquals('value', $json->key);

        $json = new Json(['name' => 'Yada Khov']);
        $this->assertEquals('Yada Khov', $json->name);
    }
}
