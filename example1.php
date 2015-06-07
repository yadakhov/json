<?php

require __DIR__.'/vendor/autoload.php';

use Yadakhov\Json;

$json = new Json(
    [
        'developer' => [
            'firstName' => 'Yada'
        ]
    ]
);

echo $json.PHP_EOL;  // {"developer":{"firstName":"Yada"}}

$json->set('developer.lastName', 'Khov');

echo $json.PHP_EOL;  // {"developer":{"firstName":"Yada","lastName":"Khov"}}

echo $json->get('developer.firstName').PHP_EOL;  // Yada

var_dump($json->toArray());

//array(1) {
//    ["developer"]=>
//  array(2) {
//        ["firstName"]=>
//    string(4) "Yada"
//    ["lastName"]=>
//    string(4) "Khov"
//  }
//}
