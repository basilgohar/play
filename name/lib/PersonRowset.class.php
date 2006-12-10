<?php

require_once 'Zend/Db/Table/Rowset.php';

class PersonRowset extends Zend_Db_Table_Rowset
{
    public function current()
    {
        // is the pointer at a valid position?
        if (! $this->valid()) {
            return false;
        }
        
        // do we already have a row object for this position?
        if (empty($this->_rows[$this->_pointer])) {
            // create a row object
            $this->_rows[$this->_pointer] = new Person(array(
                'db'    => $this->_db,
                'table' => $this->_table,
                'data'  => $this->_data[$this->_pointer]
            ));
        }
        
        // return the row object
        return $this->_rows[$this->_pointer];
    }    
}
