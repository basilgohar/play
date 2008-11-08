<?php

class Person
{
    protected $attributes = array();

    public function __construct(array $attributes = array())
    {
        $this->attributes = $attributes;
    }

    public function getAttribute($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        } else {
            return false;
        }
    }

    public function setAttribute($key, $value)
    {
        if (isset($this->attributes[$key])) {
            $this->attributes[$key] = $value;
            return true;
        } else {
            return false;
        }
    }
}
