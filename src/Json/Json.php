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

/**
 * Class Json
 *
 * @package Yadakhov
 */
class Json
{

    /**
     * Constructor
     *
     *
     * @param array $data
     * @param bool $prettyPrint
     * @throws \Exception
     */
    public function __construct($data = [], $prettyPrint = false)
    {
        // convert json string to object
        if (is_null($data)) {
            $this->data = null;
        } elseif (is_string($data)) {

        } elseif (is_array($data)) {

        } elseif ($data instanceof \stdClass) {

        } else {
            throw new \Exception('Unable to construct Json object');
        }
        $this->prettyPrint = $prettyPrint;
    }

    /**
     * The main data for the json object
     * @var array|null
     */
    protected $data = null;

    /**
     * Weather or not to use indentation in the json
     * @var bool
     */
    protected $prettyPrint = false;

    /**
     * The indentation.  use \t for tabs
     * @var string
     */
    protected $indentation = '  ';

    /**
     * @return boolean
     */
    public function isPrettyPrint()
    {
        return $this->prettyPrint;
    }

    /**
     * @param boolean $prettyPrint
     */
    public function setPrettyPrint($prettyPrint)
    {
        $this->prettyPrint = $prettyPrint;
    }

    /**
     * The getter return as array instead
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_get($this->data, $key, $default);
    }

    /**
     * The setter
     *
     * @param $key
     * @param $value
     * @return array
     */
    public function set($key, $value)
    {
        return Jason::arraySet($this->data, $key, $value);
    }

    public function toArray()
    {
        return $this->data;
    }

    public function toJson()
    {
        return Util::arrayToObject($this->data);
    }

    public function toString()
    {
        return (string)$this;
    }

    /**
     * To string
     *
     * @return mixed|string|void
     */
    public function __toString()
    {
        if ($this->isPrettyPrint()) {
            return json_encode($this->data, JSON_PRETTY_PRINT);
        }
        return json_encode($this->data);
    }

    /**
     * Flatten a multi-dimensional associative array with dots.
     *
     * @param array $array
     * @param string $prepend
     * @return array
     */
    public static function arrayDot($array, $prepend = '')
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $results = array_merge($results, static::arrayDot($value, $prepend . $key . '.'));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
    }

    /**
     * Set an array item to a given value using "dot" notation.
     * If no key is given to the method, the entire array will be replaced.
     *
     * @param array $array
     * @param string $key
     * @param mixed $value
     * @return array
     */
    public static function arraySet(&$array, $key, $value)
    {
        if (is_null($key)) return $array = $value;

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            // If the key doesn't exist at this depth, we will just create an empty array
            // to hold the next value, allowing us to create the arrays to hold final
            // values at the correct depth. Then we'll keep digging into the array.
            if ( ! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }

            $array =& $array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }

    /**
     * Get an item from an array using "dot" notation.
     *
     * @param array $array
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function arrayGet($array, $key, $default = null)
    {
        if (is_null($key)) {
            return $array;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }

    /**
     * Check if an item exists in an array using "dot" notation.
     *
     * @param  array $array
     * @param  string $key
     * @return bool
     */
    public static function arrayHas($array, $key)
    {
        if (empty($array) || is_null($key)) {
            return false;
        }

        if (array_key_exists($key, $array)) {
            return true;
        }

        foreach (explode('.', $key) as $segment) {
            if (!is_array($array) || !array_key_exists($segment, $array)) {
                return false;
            }

            $array = $array[$segment];
        }

        return true;
    }

}
