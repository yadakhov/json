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

/**
 * Class Json
 *
 * @package Yadakhov
 */
class Json
{

    /**
     * The main data structure for the json object
     * @var null
     */
    protected $body = null;

    /**
     * The type for the body variable.  Can be array|stdClass
     * @var string
     */
    protected $bodyType = 'array';

    /**
     *  Wether or not to use pretty print
     * @var bool
     */
    protected $prettyPrint = false;

    /**
     * Constructor
     *
     * @param null $body
     * @param bool $prettyPrint
     * @throws \Exception
     */
    public function __construct($body = null, $prettyPrint = false)
    {
        if (is_array($body) || is_null($body) || is_bool($body) || is_numeric($body)) {
            $this->body = $body;
            $this->bodyType = 'array';
        } elseif (is_string($body)) {
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

        } elseif ($body instanceof \stdClass) {
            $this->body = $body;
            $this->bodyType = 'stdClass';
        } else {
            throw new \Exception('Unable to construct Json object');
        }
        $this->prettyPrint = $prettyPrint;
    }

    /**
     * @return null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param $body
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isPrettyPrint()
    {
        return $this->prettyPrint;
    }

    /**
     * Set pretty print
     *
     * @param $prettyPrint
     * @return $this
     */
    public function setPrettyPrint($prettyPrint)
    {
        $this->prettyPrint = $prettyPrint;
        return $this;
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
        return Arr::get($this->body, $key, $default);
    }

    /**
     * The setter
     *
     * @param $key
     * @param $value
     * @return $this
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
     * To array
     * If the jason contains primitives this method will return the primitive type.
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

    public function toString()
    {
        if ($this->isPrettyPrint()) {
            $jsonString = json_encode($this->body, JSON_PRETTY_PRINT);
        } else {
            $jsonString = json_encode($this->body);
        }

        return $jsonString;
    }

    /**
     * To string
     *
     * @return mixed|string|void
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Convert object to array recursively
     *
     * @param $obj
     * @return array
     */
    public static function objectToArray($obj) {
        if (is_object($obj)) {
            $obj = (array) $obj;
        }
        if (is_array($obj)) {
            $new = [];
            foreach ($obj as $key => $val) {
                $new[$key] = Json::objectToArray($val);
            }
        } else {
            $new = $obj;
        }
        return $new;
    }

    /**
     * Convert an array into a stdClass()
     *
     * @param   array   $array  The array we want to convert
     * @return  object
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
