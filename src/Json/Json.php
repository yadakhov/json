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
        if (is_string($data)) {
            $dataOld = $data;
            $data = json_decode($dataOld);
        }
        if (is_array($data)) {
            $this->dataObject = Util::arrayToObject($data);
            $this->data = $data;
        } elseif (is_object($data)) {
            $this->dataObject = $data;
            $this->data = Util::objectToArray($data);
        } else {
            throw new \Exception('Unable to construct Response Entity');
        }
        $this->prettyPrint = $prettyPrint;
    }

    /**
     * The main data for the json object
     * @var array|null
     */
    protected $data = null;

    protected $prettyPrint = false;

    /**
     * @return array|null
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array|null $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

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
        return array_set($this->data, $key, $value);
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
