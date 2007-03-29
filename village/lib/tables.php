<?php

require_once 'Zend/Db/Table.php';
require_once 'Zend/Db/Table/Row.php';
require_once 'Zend/Db/Table/Rowset.php';

class FamilyTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'family';
    protected $_referenceMap = array(
        'Child' => array(
            'columns'       => array('person_id'),
            'refTableClass' => 'PersonTable',
            'refColumns'    => array('id')
        ),
        'Father' => array(
            'columns'       => array('father_id'),
            'refTableClass' => 'PersonTable',
            'refColumns'    => array('id')
        ),
        'Motherr' => array(
            'columns'       => array('mother_id'),
            'refTableClass' => 'PersonTable',
            'refColumns'    => array('id')
        )
    );
}

class MarriageTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'marriage';
    protected $_rowClass = 'Marriage';
    protected $_referenceMap = array(
        'Husband' => array(
            'columns'       => array('husband_id'),
            'refTableClass' => 'PersonTable',
            'refColumns'    => array('id')
        ),
        'Wife' => array(
            'columns'       => array('wife_id'),
            'refTableClass' => 'PersonTable',
            'refColumns'    => array('id')
        )
    );
}

class NameTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'name';
    
    public function fetchRandom($type = 'last')
    {
        $types = array('female', 'male', 'last');
        if (! in_array($type, $types)) {
            return false;
        }
        
        return $this->fetchRow("`type` = '$type'", 'RAND()');
    }
}

class PersonTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'person';
    protected $_rowClass = 'Person';
    protected $_dependentTables = array('FamilyTable', 'MarriageTable');
}
