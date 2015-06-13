<?php
/*
 * This file is part of the Json package.
 *
 * (c) Yada Khov <yada.khov@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Yadakhov;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use JsonSerializable;

/**
 * Class Json.  A wrapper class for json.
 * Provide a simple api and dot notation to work with json.
 *
 * @package Yadakhov
 */
class Json implements JsonSerializable
{
    /**
     * The main data structure for the json object.  Can be array or stdClass.
     *
     * @var null
     */
    protected $body = null;

    /**
     * The type for the body variable.  Can be array|stdClass.
     *
     * @var string
     */
    protected $bodyType = 'array';

    /**
     *  Whether or not to use pretty print.
     *
     * @var bool
     */
    protected $prettyPrint = false;

    /**
     * Constructor.
     *
     * @param null $body
     * @param bool $prettyPrint
     *
     * @throws \Exception
     */
    public function __construct($body = null, $prettyPrint = false)
    {
        if (is_array($body) || is_null($body) || is_bool($body) || is_numeric($body)) {
            $this->body = $body;
            $this->bodyType = 'array';
        } elseif (filter_var($body, FILTER_VALIDATE_URL) !== false) {
            // valid url is passed in
            $content = file_get_contents($body);
            $this->parseStringJson($content);
        } elseif (is_string($body)) {$body = trim($body);
            $this->parseStringJson($body);
        } elseif (is_object($body)) {
            $this->body = $body;
            $this->bodyType = 'stdClass';
        } else {
            throw new \Exception('Unable to construct Json object');
        }
        $this->prettyPrint = $prettyPrint;
    }

    /**
     * The factory method.
     * Returns a new Jason object.
     *
     * @return Json
     */
    public static function create()
    {
        return new Json;
    }

    /**
     * Parse the string json representation
     *
     * @param $body
     */
    private function parseStringJson($body)
    {
        $body = trim($body);
        // convert json string to object
        if (Str::startsWith($body, '[') && Str::endsWith($body, ']')) {
            $this->body = json_decode($body, true);
            $this->bodyType = 'array';
        } elseif (Str::startsWith($body, '{') && Str::endsWith($body, '}')) {
            $jsonObject = json_decode($body);
            if (is_null($jsonObject)) {
                throw new \InvalidArgumentException($body.' is not in valid json format.');
            }
            $this->body = $jsonObject;
            $this->bodyType = 'stdClass';
        } else {
            $body = '"'.$body.'"';
            $this->body = json_decode($body, true);
            $this->bodyType = 'array';
        }
    }

    /**
     * Return true if prettyPrint is set
     *
     * @return bool
     */
    public function isPrettyPrint()
    {
        return $this->prettyPrint;
    }

    /**
     * Set pretty print.
     *
     * @param $prettyPrint
     *
     * @return $this
     */
    public function setPrettyPrint($prettyPrint)
    {
        $this->prettyPrint = $prettyPrint;

        return $this;
    }

    /**
     * The getter return as array instead.
     *
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if ($this->bodyType === 'array') {
            return Arr::get($this->body, $key, $default);
        } elseif ($this->bodyType === 'stdClass') {
            return static::objectGet($this->body, $key, $default);
        }
    }

    /**
     * The setter.
     *
     * @param $key
     * @param $value
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function set($key, $value)
    {
        if ($this->bodyType === 'array') {
            Arr::set($this->body, $key, $value);
        } elseif ($this->bodyType === 'stdClass') {
            $this->body->$key = $value;
        }

        return $this;
    }

    /**
     * To array.  Get the array version of the body.
     * If the json contains primitives this method will return the primitive type.
     *
     * @return array|null|\stdClass
     */
    public function toArray()
    {
        if ($this->bodyType === 'array') {
            return $this->body;
        } elseif ($this->bodyType === 'stdClass') {
            return static::objectToArray($this->body);
        }
    }

    /**
     * To string.
     * Non pretty version.
     *
     * @return string
     */
    public function toString()
    {
        return $jsonString = json_encode($this->body);
    }

    /**
     * To String Pretty Version. Add end of line character to the end.
     *
     * @return string
     */
    public function toStringPretty()
    {
        return json_encode($this->body, JSON_PRETTY_PRINT) . PHP_EOL;
    }

    /**
     * To string for used in casting.  (strong)$json
     * Will look at $this->prettyPrint property to determine whether to do a pretty print.
     *
     * @return mixed|string|void
     */
    public function __toString()
    {
        if ($this->isPrettyPrint()) {
            return $this->toStringPretty();
        } else {
            return $this->toString();
        }
    }

    /**
     * PHP get magic function.
     *
     * @param $name
     * @return mixed
     * @throws Exception
     */
    public function __get($name)
    {
        if ($this->bodyType === 'array' && Arr::has($this->body, $name)) {
            return Arr::get($this->body, $name);
        } elseif ($this->bodyType === 'stdClass' && isset($this->body->{$name})) {
            return $this->body->{$name};
        }

        throw new \Exception(sprintf('Non-existent property %s.', $name));
    }

    /**
     * Returns data which can be serialized by json_encode().
     *
     * @return mixed
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Return true is the string is a valid Json notation
     * Note: unlike javascript quotes must be use for the key.
     * This is not a valid json {status => "success"}.  Must be  {"status" => "success"}.
     *
     * @param $string
     *
     * @return bool
     */
    public static function isJson($string)
    {
        json_decode($string);

        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Convert object to array recursively.
     *
     * @param $obj
     *
     * @return array
     */
    public static function objectToArray($obj)
    {
        if (is_object($obj)) {
            $obj = (array) $obj;
        }
        if (is_array($obj)) {
            $new = [];
            foreach ($obj as $key => $val) {
                $new[$key] = self::objectToArray($val);
            }
        } else {
            $new = $obj;
        }

        return $new;
    }

    /**
     * Convert an array into a stdClass().
     *
     * @param array $array The array we want to convert
     *
     * @return object
     */
    public static function arrayToObject($array)
    {
        // Convert the array to a json string
        $json = json_encode($array);
        // Convert the json string to a stdClass()
        $object = json_decode($json);

        return $object;
    }

    /**
     * Get an item from an object using "dot" notation.
     *
     * @param stdClass $object
     * @param string   $key
     * @param mixed    $default
     *
     * @return mixed
     */
    public static function objectGet($object, $key, $default = null)
    {
        if (is_null($key)) {
            return $object;
        }

        if (property_exists($object, $key)) {
            return $object->$key;
        }

        foreach (explode('.', $key) as $segment) {
            if (property_exists($object, $segment)) {
                $object = $object->$segment;
            } else {
                return value($default);
            }
        }

        return $object;
    }

}
