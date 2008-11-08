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
        
        $name_ids = $this->getAdapter()->fetchCol("SELECT `id` FROM `Names` WHERE `type` = '$type'");
        
        $random_name_id = $name_ids[mt_rand(0, count($name_ids) - 1)];
        
        return $this->fetchRow("`id` = $random_name_id");
    }
}

class People extends Zend_Db_Table_Abstract
{
    protected $_rowClass = 'Person';
    protected $_dependentTables = array('Families', 'Marriages');
    
    public function fetchRandomPersonEligableForMarriage($gender)
    {
        switch ($gender) {
            default:
                throw new Exception('Invalid gender "' . $gender . '" specified.');
                break;
            case 'male':
                $marriage_field = 'husband_id';
                $count = VILLAGE_SPOUSE_MAX_MALE;
                break;
            case 'female';
                $marriage_field = 'wife_id';
                $count = VILLAGE_SPOUSE_MAX_FEMALE;
                break;
        }
        $sql = "SELECT p.id FROM People p LEFT JOIN Marriages m ON m.$marriage_field = p.id WHERE gender = '$gender' GROUP BY p.id HAVING COUNT(m.id) < $count ORDER BY RAND() LIMIT 1";
        $people_ids = array_values($this->getAdapter()->fetchCol($sql));
        if (count($people_ids) > 0) {
            $person_id = current($people_ids);
            return $this->fetchRow("`id` = $person_id");
        } else {
            return false;
        }
    }
    
    public function fetchPeopleEligableForMarriage($gender)
    {
        switch ($gender) {
            default:
                throw new Exception('Invalid gender "' . $gender . '" specified.');
                break;
            case 'male':
                $sub_sql = "SELECT p.id FROM `People` p LEFT JOIN `Marriages` m ON m.husband_id = p.id WHERE p.gender = 'male' GROUP BY p.id HAVING COUNT(m.id) < " . VILLAGE_SPOUSE_MAX_MALE;
                break;
            case 'female':
                $sub_sql = "SELECT p.id FROM `People` p LEFT JOIN `Marriages` m ON m.wife_id = p.id WHERE p.gender = 'female' GROUP BY p.id HAVING COUNT(m.id) < " . VILLAGE_SPOUSE_MAX_FEMALE;
                break;
        }
        //$records = $this->getAdapter()->query($sub_sql)->fetchAll();
        return $this->getAdapter()->query($sub_sql)->fetchAll(PDO::FETCH_COLUMN);
        //return new Zend_Db_Table_Rowset(array('data' => $records, 'rowClass' => $this->_rowClass, 'table' => $this));
    }
    
    public function fetchOrderedRowset($limit = 1000, $offset = 0)
    {
        $sql = "SELECT * FROM People ORDER BY name_last, name_first LIMIT $offset, $limit";
        return new Zend_Db_Table_Rowset(array('table' => $this, 'data' => $this->getAdapter()->fetchAll($sql)));
    }
}

class Info extends Zend_Db_Table_Abstract
{
    protected $_name = 'Info';
}

class Objects extends Zend_Db_Table_Abstract
{
    protected $_name = 'Objects';
}

class Villages extends Zend_Db_Table_Abstract
{
    protected $_name = 'Villages';
}

class PeopleMarriageCount extends Zend_Db_Table_Abstract
{
    protected $_name = 'PeopleMarriageCount';
}
