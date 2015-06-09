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
     *  Wether or not to use pretty print.
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
        } elseif (filter_var($body, FILTER_VALIDATE_URL) !== false) {
            // A valid url is passed in
            $content = file_get_contents($body);
            $content = trim($content);
            if (Str::startsWith($content, '{') && Str::endsWith($content, '}')) {
                $data = json_decode($content, true);
                if (is_null($data)) {
                    throw new \InvalidArgumentException($content . ' is not in valid json format.');
                }
                $this->body = $data;
            }
        } elseif (is_string($body)) {
            $body = trim($body);
            // convert json string to object
            if (Str::startsWith($body, '[') && Str::endsWith($body, ']')) {
                $this->body = json_decode($body, true);
            } elseif (Str::startsWith($body, '{') && Str::endsWith($body, '}')) {
                $data = json_decode($body, true);
                if (is_null($data)) {
                    throw new \InvalidArgumentException($body.' is not in valid json format.');
                }
                $this->body = $data;
            } else {
                $body = '"'.$body.'"';
                $this->body = json_decode($body, true);
            }
        } elseif (is_object($body)) {
            $this->body = Json::objectToArray($body);
        } else {
            throw new \Exception('Unable to construct Json object');
        }
        $this->prettyPrint = $prettyPrint;
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
        return Arr::get($this->body, $key, $default);
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
        Arr::set($this->body, $key, $value);
        return $this;
    }

    /**
     * To array
     * If the jason contains primitives this method will return the primitive type.
     *
     * @return array|null|\stdClass
     */
    public function toArray()
    {
        return $this->body;
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
     * To string.
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
    protected function objectToArray($obj) {
        if (is_object($obj)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $obj = get_object_vars($obj);
        }

        if (is_array($obj)) {
            // Return array converted to object for recursive call
            return array_map(__FUNCTION__, $obj);
        } else {
            // Return array
            return $obj;
        }
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

}
