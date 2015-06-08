# [Json](http://github.com/yadakhov/json)

A simple wrapper class for Json.

Work with json as a Json object in PHP.  Provide a simple api and dot notation.

Use get() or set() to access any elements in the json tree. 

```php
$json = new Json(['status' => 'success', 'developer' => ['name' => 'Yada Khov']);
echo $json . PHP_EOL;  // {"status":"success"}
$json->set('status', 'winning');
echo $json . PHP_EOL;  // {"status":"winning"}.
``

## Installation

<a name="install-composer"/>
### With Composer

```
$ composer require yadakhov/json
```

```json
{
    "require": {
        "yadakhov/json": "~1.0"
    }
}
```

## Usage
```php
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
```

## Creating Json objects
```php
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
```

## Design decision
All keys in a json need to be quoted to be a valid json.

Bad:
```json
{
    status: "success"
}
```
Good:
```json
{
    "status": "success"
}
```

## Dependencies
PHP 5.4 for short array syntax.

This package uses illuminate/support for the array and string helpers.
Standing on the shoulders of giants.
