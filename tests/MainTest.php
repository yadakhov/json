<?php

use Yadakhov\Json;

class MainTest extends TestCase
{
    public function testPassingNullToConstructor()
    {
        $json = new Json(null);
        $this->assertEquals(null, $json->toArray());
        $this->assertEquals('null', $json->toString());
    }

    public function testPassingBooleanConstructor()
    {
        $json = new Json(true);
        $this->assertEquals(true, $json->toArray());
        $this->assertEquals('true', $json->toString());


        $json = new Json(false);
        $this->assertEquals(false, $json->toArray());
        $this->assertEquals('false', $json->toString());
    }

    public function testPassingNumericToConstructor()
    {
        $json = new Json(1);
        $this->assertEquals(1, $json->toArray());
        $this->assertEquals('1', $json->toString());

        $json = new Json(-200);
        $this->assertEquals(-200, $json->toArray());
        $this->assertEquals('-200', $json->toString());

        $json = new Json(3.141592);
        $this->assertEquals(3.141592, $json->toArray());
        $this->assertEquals('3.141592', $json->toString());

        $json = new Json(-5);
        $this->assertEquals(-5, $json->toArray());
        $this->assertEquals('-5', $json->toString());
    }

    public function testPassingStringToConstructor()
    {
        $json = new Json('"foo"');
        $this->assertEquals('foo', $json->toArray());
        $this->assertEquals('"foo"', $json->toString());

        $json = new Json('{}');
        $this->assertEquals([], $json->toArray());
        $this->assertEquals('[]', $json->toString());

        $json = new Json('[]');
        $this->assertEquals([], $json->toArray());
        $this->assertEquals('[]', $json->toString());

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

    public function testToArrayPrimitiveJson()
    {
        $json = new Json(9000);
        $this->assertEquals(9000, $json->toArray());
        $this->assertEquals('9000', $json->toString());

        $json = new Json(3.14);
        $this->assertEquals(3.14, $json->toArray());
        $this->assertEquals(3.14, $json->toString());

        $json = new Json('"string"');
        $this->assertEquals('string', $json->toArray());
        $this->assertEquals('"string"', $json->toString());

        $json = new Json(true);
        $this->assertEquals(true, $json->toArray());

        $json = new Json(null);
        $this->assertEquals(null, $json->toArray());
    }

    public function testGetInstance()
    {
        $json = Json::getInstance();

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
