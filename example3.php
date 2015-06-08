<?php

require __DIR__.'/vendor/autoload.php';

use Yadakhov\Json;

// Using get and set with dot notation

$json = new Json(
    [
        'status' => 'success',
        'data' => [
            'name' => 'Yada',
            'job' => 'developer'
        ]
    ]
    , true  // set pretty print to true.  (optional)
);

echo $json . PHP_EOL;
/*
{
    "status": "success",
    "data": {
        "name": "Yada",
        "job": "developer"
    }
}
*/

// Use dot notation to access second level elements
$json->set('data.name', 'Liam Neeson');
$json->set('data.job', 'actor');
echo $json . PHP_EOL;
/*
{
    "status": "success",
    "data": {
        "name": "Liam Neeson",
        "job": "actor"
    }
}
*/
