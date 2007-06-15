<?php

class db_column
{
    protected $attributes = array (
        'name' => '',
        'type' => '',
        'unsigned' => true,
        'default' => ''        
    );    
    
    public function __construct($attributes = array())
    {
        
    }
    
    public function __set($name = null, $value = null)
    {
        if (null === $name) {
            return false;
        }
    }
    
    public function __get($name = null)
    {
        if (null === $name) {
            return false;
        }
    }
    
}