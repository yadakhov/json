<?php

/*
 * This file is part of the Json package.
 *
 * (c) Yada Khov <yada.khov@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class ArrayFunctionsTest extends BootstrapTest
{
    public function testArrayDot()
    {
        $json = new Json;
        $this->invokeMethod($json, 'arrayDot', array('passwordToCrypt'));
    }

}
