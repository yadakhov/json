<?php

namespace Yadakhov;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use JsonSerializable;

/**
 * Class Json.
 * A simple class to work with json as an object.
 *
 * @package Yadakhov
 */
class Json implements JsonSerializable
{
    /**
     * The main data for the json object.
     *
     * @var mixed|null
     */
    protected $data = null;

    /**
     * Json constructor.
     *
     * @param null $data
     * @throws \Exception
     */
    public function __construct($data = null)
    {
        if (is_array($data) || is_null($data) || is_bool($data) || is_numeric($data)) {
            $this->data = $data;
        } elseif (is_string($data)) {
            $this->data = json_decode($data, true);

            if (json_last_error()) {
                throw new \Exception('Unable to parse json string: \'' . $data . '\'. ' . json_last_error_msg());
            }
        } else {
            throw new \Exception('Unable to construct Json object with: ' . json_encode($data));
        }
    }

    /**
     * Get an instance of the object.
     *
     * @param null $data
     * @return Json
     */
    public static function getInstance($data = null)
    {
        return new Json($data);
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
        return Arr::get($this->data, $key, $default);
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
        Arr::set($this->data, $key, $value);

        return $this;
    }

    /**
     * To array.
     * If the json contains primitives this method will return the primitive type.
     *
     * @return mixed|null
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * To string for used in casting.  (string)$json
     * Will look at $this->prettyPrint property to determine whether to do a pretty print.
     *
     * @return mixed|string|void
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * To string.
     *
     * @return string
     */
    public function toString()
    {
        return json_encode($this->data);
    }

    /**
     * To String Pretty Version. Add end of line character to the end.
     *
     * @return string
     */
    public function toStringPretty()
    {
        return json_encode($this->data, JSON_PRETTY_PRINT) . PHP_EOL;
    }

    /**
     * PHP get magic function.
     *
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * PHP get magic function.
     *
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * PHP isset magic function.
     *<
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return Arr::has($this->data, $name);
    }

    /**
     * PHP unset magic function.
     *
     * @param $name
     * @return bool
     */
    public function __unset($name)
    {
        return $this->set($name, null);
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
     * Return true is the string is a valid Json notation.
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
}
