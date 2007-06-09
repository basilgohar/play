<?php

require_once 'Zend/Db/Table.php';
require_once 'Zend/Db/Table/Row.php';
require_once 'Zend/Db/Table/Rowset.php';

class Families extends Zend_Db_Table_Abstract
{
    protected $_referenceMap = array(
        'Child' => array(
            'columns'       => array('person_id'),
            'refTableClass' => 'People',
            'refColumns'    => array('id')
        ),
        'Father' => array(
            'columns'       => array('father_id'),
            'refTableClass' => 'People',
            'refColumns'    => array('id')
        ),
        'Mother' => array(
            'columns'       => array('mother_id'),
            'refTableClass' => 'People',
            'refColumns'    => array('id')
        )
    );
}

class Marriages extends Zend_Db_Table_Abstract
{
    protected $_rowClass = 'Marriage';
    protected $_referenceMap = array(
        'Husband' => array(
            'columns'       => array('husband_id'),
            'refTableClass' => 'People',
            'refColumns'    => array('id')
        ),
        'Wife' => array(
            'columns'       => array('wife_id'),
            'refTableClass' => 'People',
            'refColumns'    => array('id')
        )
    );
}

class Names extends Zend_Db_Table_Abstract
{
    protected $_dependentTables = array('People');
    
    public function fetchRandom($type = 'last')
    {
        $types = array('female', 'male', 'last');
        if (! in_array($type, $types)) {
            return false;
        }
        
        return $this->fetchRow("`type` = '$type'", 'RAND()');
    }
}

class People extends Zend_Db_Table_Abstract
{
    protected $_rowClass = 'Person';
    protected $_dependentTables = array('Families', 'Marriages');
    protected $_referenceMap = array(
        'FirstName' => array(
            'columns'		=> array('name_first_id'),
            'refTableClass'	=> 'Names',
            'refColumns'	=> array('id')
        ),
        'LastName' => array(
            'columns'		=> array('name_last_id'),
            'refTableClass'	=> 'Names',
            'refColumns'	=> array('id')
        )
    );
    
    public function fetchRandomEligableForMarriage($gender)
    {
        switch ($gender) {
            default:
                throw new Exception('Invalid gender "' . $gender . '" specified.');
                break;
            case 'male':
                $sql = "SELECT `p`.`id`, COUNT(*) `c`, `m`.`id` mid FROM `People` `p` LEFT JOIN `Marriages` m ON `p`.`id` = `m`.`husband_id` GROUP BY `p`.`id` ORDER BY `c` ASC , RAND() LIMIT 1";
                break;
            case 'female':
                $sql = "SELECT `p`.`id`, COUNT(*) `c`, `m`.`id` mid FROM `People` `p` LEFT JOIN `Marriages` m ON `p`.`id` = `m`.`wife_id` GROUP BY `p`.`id` ORDER BY `c` ASC , RAND() LIMIT 1";
                break;
        }
        return $this->getAdapter()->fetchAssoc($sql);        
    }
}
