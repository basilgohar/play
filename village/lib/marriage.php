<?php

require_once 'Zend/Db/Table/Row.php';

class Marriage extends Zend_Db_Table_Row
{
    protected $husband = null;
    protected $wife = null;
    
    public function getHusband()
    {
        if (null === $this->husband) {
            $person_table = new Persons();
            $this->husband = $person_table->fetchRow('`id` = ' . $this->husband_id);
        }
        return $this->husband;
    }
    
    public function getWife()
    {
        if (null === $this->wife) {
            $person_table = new Persons();
            $this->wife = $person_table->fetchRow('`id` = ' . $this->wife_id);
        }
        return $this->wife;
    }
}