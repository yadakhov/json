<?php

require __DIR__.'/vendor/autoload.php';

use Yadakhov\Json;

// Using PHP objects to instantiate a new json object

$dateTime = new DateTime();

var_dump($dateTime);
/*
object(DateTime)#2 (3) {
["date"]=>
  string(19) "2015-06-08 06:26:11"
  ["timezone_type"]=>
  int(3)
  ["timezone"]=>
  string(16) "America/New_York"
}
*/

$json = new Json($dateTime);

echo $json->toStringPretty();
/*
{
    "date": "2015-06-08 06:26:11",
    "timezone_type": 3,
    "timezone": "America\/New_York"
}
*/

var_dump($json->toArray());
