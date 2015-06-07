<?php

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../src/Json/Json.php';

use Yadakhov\Json;

$json = new Json(['name' => 'Yada']);

echo $json;  // prints {"name":"Yada"}

$json->set('name', 'John');

echo $json;  // prints {"name":"John"}
