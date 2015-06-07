# Json

A simple API extension class for Json. [http://github.com/yadakhov/json](http://github.com/yadakhov/json)

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

$json = new Json(['name' => 'Yada']);

echo $json;  // prints {"name":"Yada"}

$json->set('name', 'John');

echo $json;  // prints {"name":"John"}

```

<a name="install-nocomposer"/>
### Without Composer

Why are you not using [composer](http://getcomposer.org/)? Download [Carbon.php](https://github.com/briannesbitt/Carbon/blob/master/src/Carbon/Carbon.php) from the repo and save the file into your project path somewhere.

```php
<?php
require 'path/to/Carbon.php';

use Carbon\Carbon;

printf("Now: %s", Carbon::now());
```


## Dependencies
PHP 5.4 for short array syntax.

This package uses illuminate/support for the array and string helpers. Standing on the shoulders of giants.
