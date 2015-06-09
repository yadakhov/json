<?php

require __DIR__.'/vendor/autoload.php';

use Yadakhov\Json;

// Usage
// There are three ways to instantiation a new Json object

// 1. PHP array
$json1 = new Json(['status' => 'success']);

echo $json1 . PHP_EOL;  // {"status":"success"}

// 2. Json string
$json2 = new Json('{"status":"success"}');

echo $json2 . PHP_EOL;  // {"status":"success"}

// 3. PHP stdClass
$object = new stdClass();
$object->status = 'success';
$json3 = new Json($object);

echo $json3 . PHP_EOL;  // {"status":"success"}

// 4. An valid url that returns an json string
$json4 = new Json('https://api.ipify.org?format=json');

echo $json4 . PHP_EOL;  // {"ip":"135.123.123.123"}

