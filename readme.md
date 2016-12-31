# [Json](http://github.com/yadakhov/json)

[![Latest Stable Version](https://poser.pugx.org/yadakhov/json/version)](https://packagist.org/packages/yadakhov/json)
[![License](https://poser.pugx.org/yadakhov/json/license)](https://packagist.org/packages/yadakhov/json)
[![Build Status](https://travis-ci.org/yadakhov/json.svg)](https://travis-ci.org/yadakhov/json)

A simple wrapper class for working with Json.

Work with json as an object in PHP.  Provides a simple api with dot notation for field access.

Use get() or set() to access any fields in the json structure.

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

### Old fashion php
```php
// download src/Json.php to your code folder..
require_once '/path/to/Json.php';

use Yadakhov/Json;

$json = new Json();
```

## Usage: The Constructor

Will to accept array or json encoded string.

```php
// There are 2 ways to instantiation a new Json object

// 1.
$json1 = new Json('{"status":"success"}');

// 2
$json2 = new Json(['status' => 'success']);
```

## API functions
```php
$json->get('dot.notation') - get a field
$json->set('dot.notation', $value) - set a field
$json->toString() - return the Json object as a string
$json->toStringDot() - return the dot notation of the structure.
$json->toStringPretty() - json pretty print
$json->toArray() - return the array representation.
```

## Design decision
Internally, the json is stored as a PHP array.  This allows us to use dot notation.

The left hand side of a json encoded string needs to be double quoted.
```json
{
    "status": "success"
}
```

## Dependencies
PHP 5.4 for short array syntax.

This package uses illuminate/support for the array and string helpers.

## Run tests

```
./vendor/bin/phpunit 
```
