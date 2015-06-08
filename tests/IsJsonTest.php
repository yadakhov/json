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

class IsJsonTest extends BootstrapTest
{

    public function testPrimitives()
    {
        $this->assertTrue(Json::isJson('null'));
        $this->assertTrue(Json::isJson('true'));
        $this->assertTrue(Json::isJson('false'));
        $this->assertTrue(Json::isJson('9001'));
        $this->assertTrue(Json::isJson('-3.14'));
    }

    public function testEmptyString()
    {
        // empty string will return true
        $this->assertTrue(Json::isJson(''));
    }

    public function testNotJsonString()
    {
        $this->assertFalse(Json::isJson("['status' => 'success']"));
    }

    public function testSimpleJson()
    {
        $this->assertTrue(Json::isJson('{"status":"success"}'));
    }

    public function testNoQuoteJson()
    {
        $this->assertFalse(Json::isJson('{status:"success"}'));
    }

    public function testMoreComplexJson()
    {
        $this->assertTrue(Json::isJson('{
            "status" : "success",
            "data" : {
                "post" : { "id" : 1, "title" : "A blog post", "body" : "Some useful content" }
            }
        }'));
    }

}
