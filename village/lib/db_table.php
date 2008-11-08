<?php

class db_table
{
    protected $columns = array();
    
    protected $attributes = array(
        'ENGINE' => '',
        'COLLATE' => '',
        'COMMENT' => ''
    );
    
    public function __construct($attributes = null)
    {
        
    }
    
    public function addColumn(db_column $column)
    {
        
    }
}