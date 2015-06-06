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

}
