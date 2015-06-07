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
     * Constructor
     *
     * @param null $body
     * @param bool $prettyPrint
     * @throws \Exception
     */
    public function __construct($body = null, $prettyPrint = false)
    {
        if (is_array($body) || is_null($body) || is_bool($body)) {
            $this->body = $body;
        } elseif (is_string($body)) {

            // convert json string to object
            if (Str::startsWith($body, '[') && Str::endsWith($body, ']')) {
                $this->body = json_decode($body, true);
            } else {
                $body = '"'.$body.'"';
                $this->body = json_decode($body, true);
            }

        } elseif ($body instanceof \stdClass) {

        } else {
            throw new \Exception('Unable to construct Json object');
        }
        $this->prettyPrint = $prettyPrint;
    }


    /**
     * The main data structure for the json object
     * @var null
     */
    protected $body = null;

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
     * @return null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param null $body
     */
    public function setBody($body)
    {
        $this->body = $body;
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
     * @return array
     */
    public function set($key, $value)
    {
        return Arr::set($this->body, $key, $value);
    }

    public function toArray()
    {
        return $this->body;
    }

    public function toJson()
    {

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

}
