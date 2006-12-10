<?php

class Person
{

    /**
     * Enter description here...
     *
     * @var Zend_Db_Table_Row
     */
    protected $person_row;
        
    public function __construct(Zend_Db_Table_Row $person)
    {
        $this->person_row = $person;
    }
    
    public function __get($name)
    {
        return $this->person_row->__get($name);
    }
    
    public function __set($name, $value = null)
    {
        return $this->person_row->__set($name, $value);
    }
    
    public function __toString()
    {
        return $this->name_first  . ' ' . $this->name_last . ' (' . $this->id . ')';
    }
    
    public function getChildren()
    {
        
    }
    
    public function getParents()
    {
        
    }
    
    public function isMarried()
    {
        
    }
    
    public function getSpouse()
    {
        
    }
    
    public function canMarry(Person $potential_spouse)
    {
        
    }
    
    public function isEligableForMarriage()
    {
        
    }
}