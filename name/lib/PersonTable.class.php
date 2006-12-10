<?php

require_once 'Zend/Db/Table.php';

class PersonTable extends Zend_Db_Table
{
    protected $_name = 'person_view';
    
    public function __construct($config = null)
    {
        parent::__construct($config);
    }
    
    public function fetchAll($where = null, $order = null, $count = null, $offset = null)
    {
        return new PersonRowset(array(
            'db'    => $this->_db,
            'table' => $this,
            'data'  => $this->_fetch('All', $where, $order, $count, $offset),
        ));
    }
    
    public function fetchRow($where = null, $order = null)
    {
        return new Person(array(
            'db'    => $this->_db,
            'table' => $this,
            'data'  => $this->_fetch('Row', $where, $order, 1),
        ));        
    }
    
    public function fetchNew()
    {
        $keys = array_keys($this->_cols);
        $vals = array_fill(0, count($keys), null);
        return new Person(array(
            'db'    => $this->_db,
            'table' => $this,
            'data'  => array_combine($keys, $vals),
        ));        
    }
}
