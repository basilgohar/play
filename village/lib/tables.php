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
        'Mother' => array(
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
    protected $_dependentTables = array('PersonTable');
    
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
    protected $_referenceMap = array(
        'FirstName' => array(
            'columns'		=> array('name_first_id'),
            'refTableClass'	=> 'NameTable',
            'refColumns'	=> array('id')
        ),
        'LastName' => array(
            'columns'		=> array('name_last_id'),
            'refTableClass'	=> 'NameTable',
            'refColumns'	=> array('id')
        )
    );
    
    public function fetchRandomEligableForMarriage($gender = 'female')
    {
        switch ($gender) {
            default:
                throw new Exception('Invalid gender "' . $gender . '" specified.');
                break;
            case 'male':
                $sql = "SELECT `p`.`id`, COUNT(*) `c`, `m`.`id` mid FROM `person` `p` LEFT JOIN `marriage` m ON `p`.`id` = `m`.`husband_id` GROUP BY `p`.`id` ORDER BY `c` ASC , RAND() LIMIT 1";
                break;
            case 'female':
                $sql = "SELECT `p`.`id`, COUNT(*) `c`, `m`.`id` mid FROM `person` `p` LEFT JOIN `marriage` m ON `p`.`id` = `m`.`wife_id` GROUP BY `p`.`id` ORDER BY `c` ASC , RAND() LIMIT 1";
                break;
        }
        return $this->getAdapter()->fetchAssoc($sql);        
    }
    
    public function fetchPeopleEligableForMarrage($gender = null)
    {
        
    }
    
    /*
    public function fetchOrdered($limit = 0)
    {
        $sql = "SELECT p.id FROM person p JOIN name name_first ON p.name_first_id = name_first.id JOIN name name_last ON p.name_last_id = name_last.id ORDER BY name_last.value ASC , name_first.value ASC LIMIT $limit";
        $result = $this->getAdapter()->query($sql);
        print_r($result);
        exit;
        //return $this->find($result);
    }
    */
}
