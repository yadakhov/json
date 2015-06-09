# [Json](http://github.com/yadakhov/json)

A simple wrapper class for Json.

Work with json as an object in PHP.  Provide a simple api with dot notation for field access.

Use get() or set() to access any fields in the json tree.  No more json_encode and json_decode.

```php
require __DIR__.'/vendor/autoload.php';
use Yadakhov\Json;

$json = new Json(['status' => 'success', 'developer' => ['name' => 'Yada Khov']]);
echo $json;  // {"status":"success","developer":{"name":"Yada Khov"}}

$json->set('status', 'winning');
echo $json;  // {"status":"winning","developer":{"name":"Yada Khov"}}
```

## Installation

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

## Usage: The Constructor
Overloaded to accept array, php objects, json encoded string, and valid URLs. 

```php
// There are four ways to instantiation a new Json object

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

// cast (string) for __toString()
$row->column = (string)$json;
```

## API functions
```php
$json->get('dot.notation') - get a field
$json->set('dot.notation', $value) - set a field
$json->toString() - return the Json object as a string
$json->toStringPretty() - json pretty print
$json->toArray() - return the array representation.  ie.  json_decode('...', true)
(string)$json->setPrettyPrint(true) - return a json string with JSON_PRETTY_PRINT 
Json::isJson($string) - return true if string is a valid json
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
