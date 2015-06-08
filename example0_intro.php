<?php

require __DIR__.'/vendor/autoload.php';

use Yadakhov\Json;

// Using get and set with dot notation

$json = new Json(
    [
        'class' => 'Json',
        'data' => [
            'name' => 'Yada Khov',
            'job' => 'developer'
        ]
    ]
);

echo $json . PHP_EOL;
/*
{"class":"Json","data":{"name":"Yada Khov","job":"developer"}}
*/

// Use dot notation to access second level elements
$json->set('data.name', 'Liam Neeson');
$json->set('data.job', 'actor');
echo $json->toStringPretty() . PHP_EOL;
/*
{
    "class": "Json",
    "data": {
        "name": "Liam Neeson",
        "job": "actor"
    }
}
*/
