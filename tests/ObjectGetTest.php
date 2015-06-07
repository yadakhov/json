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

class ObjectGetTest extends BootstrapTest
{

    public function testSimpleObject()
    {
        $obj = new stdClass();
        $obj->name = 'Yada';

        $this->assertEquals('Yada', Json::objectGet($obj, 'name'));
    }

    public function testTwoLevelObject()
    {
        $obj = new stdClass();
        $obj->developer = new stdClass();
        $obj->developer->name = 'Yada';

        $this->assertEquals('Yada', Json::objectGet($obj, 'developer.name'));
    }

    public function testTwoLevelObjectDefault()
    {
        $obj = new stdClass();
        $obj->developer = new stdClass();
        $obj->developer->name = 'Yada';

        $this->assertEquals('default', Json::objectGet($obj, 'developer.name.notexist', 'default'));
    }

}
