# [Json](http://github.com/yadakhov/json)

A simple wrapper class for Json.

The goal of the package to to provide simple syntax such as dot notation to work with Json datatype in PHP.

Use Json as a first class object in PHP.

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

```php
<?php
require 'vendor/autoload.php';

use Yadakhov\Json;

// Instantiate a new Json object using standard PHP array

$data = array(
    'developer' => array(
        'firstName' => 'Yada'
    )
);

$json = new Json($data);

echo $json;  // Object auto convert to string.  Print: {"developer":{"firstName":"Yada"}}

$json->set('developer.lastName', 'Khov');

echo $json;  // {"developer":{"firstName":"Yada","lastName":"Khov"}}

echo $json->get('developer.firstName');  // Yada

var_dump($json->toArray());

array(1) {
  ["developer"]=>
  array(2) {
    ["firstName"]=>
    string(4) "Yada"
    ["lastName"]=>
    string(4) "Khov"
  }
}

```

## Dependencies
PHP 5.4 for short array syntax.

This package uses illuminate/support for the array and string helpers. Standing on the shoulders of giants.
