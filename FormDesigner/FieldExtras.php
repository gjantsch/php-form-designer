<?php
/**
 * Created by PhpStorm.
 * @author Gustavo Jantsch <jantsch@gmail.com>
 * @property string $from
 * @property string $fk
 * @property string $pk
 * @property string $key
 * @property string $value
 * @property string $order
 * @property string $empty
 * @property string $update
 *
 */

namespace FormDesigner;


class FieldExtras
{
    private $properties = [];
    
    public function __construct($extra)
    {

        $this->properties = [];
        if (!empty($extra) && is_string($extra)) {
            $json = json_decode($extra, true);
            $this->properties = json_last_error() == JSON_ERROR_NONE ? $json : [];
        }

    }

    public function toArray()
    {
        return $this->properties;
    }

    function __isset($name)
    {
        return isset($this->properties[$name]);
    }

    function __get($name)
    {
        return $this->properties[$name] ?? null;
    }

    function __set($name, $value)
    {
        if (isset($this->properties[$name])) {
            $this->properties[$name] = $value;
        }
    }

}