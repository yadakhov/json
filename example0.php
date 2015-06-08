<?php

require __DIR__.'/vendor/autoload.php';

use Yadakhov\Json;

$data = array(
    'developer' => array(
        'firstName' => 'Yada'
    )
);
// Instantiate a new Json object using standard PHP array
$json = new Json($data);

echo $json.PHP_EOL;  // print: {"developer":{"firstName":"Yada"}}

$json->set('developer.lastName', 'Khov');

echo $json.PHP_EOL;  // print: {"developer":{"firstName":"Yada","lastName":"Khov"}}

echo $json->get('developer.firstName').PHP_EOL;  // print: Yada

var_dump($json->toArray());

/*
array(1) {
  ["developer"]=>
  array(2) {
    ["firstName"]=>
    string(4) "Yada"
    ["lastName"]=>
    string(4) "Khov"
  }
}
*/

// It is json JsonSerializable
echo json_encode($json, JSON_PRETTY_PRINT);

/*
{
    "developer": {
    "firstName": "Yada",
        "lastName": "Khov"
    }
}
*/
