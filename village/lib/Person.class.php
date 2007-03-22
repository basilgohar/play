<?php

require_once 'Zend/Db/Table/Row.php';

class Person extends Zend_Db_Table_Row
{
    public function __construct($config = array())
    {
        parent::__construct($config);        
    }
    
    public function __toString()
    {
        return $this->nameFirst . ' ' . $this->nameLast . ' (' . $this->id . ')';
    }
    
    public function isEligableForMarriage()
    {
        switch($this->gender) {
            default:
                throw new Exception('Unknown gender');
                break;
            case 'male':
                $marriage_table = new MarriageTable();
                $result = $marriage_table->fetchAll("`husband_id` = '$this->id'");
                return ($result->count() < 5);
                break;
            case 'female':
                return ! $this->isMarried();
                break;
        }
    }
    
    /**
     * Determine whether or not two people
     * are eligable for marriage to one-another
     *
     * @param Person $potential_spouse
     * @return boolean can marry
     */
    public function canMarry(Person $potential_spouse)
    {
        if ($this->gender == $potential_spouse->gender) {
            //  Not in this state!
            return false;
        }
        
        return $this->isEligableForMarriage() && $potential_spouse->isEligableForMarriage();
    }
    
    public function marryTo(Person $spouse)
    {
        if (! $this->canMarry($spouse)) {
            throw new Exception('Impossible marriage arrangement');
        }
        
        $marriage_table = new MarriageTable();
        $marriage = $marriage_table->fetchNew();
        
        if ($this->gender == 'male') {
            $marriage->husbandId = $this->id;
            $marriage->wifeId = $spouse->id;
        } else {
            $marriage->wifeId = $this->id;
            $marriage->husbandId = $spouse->id;
        }
        
        $marriage->dateMarried = date('Y-m-d');
        $marriage->dateDivorced = '';
        
        return $marriage->save();
    }
    
    public function isMarried()
    {
        if ($this->gender == 'male') {
            $field_name = 'husband_id';
        } else {
            $field_name = 'wife_id';
        }
        
        $marriage_table = new MarriageTable();
        
        $result = $marriage_table->fetchAll("`$field_name` = '$this->id'");
        
        return ($result->count() > 0);
    }

    /**
     * Returns a rowset containing all the children
     * of this person, if any
     *
     */
    public function getChildren()
    {
        if ($this->gender == 'male') {
            $field_name = 'father_id';
        } else {
            $field_name = 'mother_id';
        }
        
        $sql = "SELECT `person_id` FROM `ancestry` WHERE `$field_name` = $this->id";
        $result = $this->_db->fetchAll($sql);
        
        if (count($result) > 0) {
            return new PersonRowset(array('db' => $this->_db, 'table' => $this->_table, 'data' => $result));
        }
    }
    
    public function getFather()
    {
        return;
    }
    
    public function getMother()
    {
        return;
    }
    
    public function getSpouse($number = 1)
    {
        
    }
    
    public function isPregnant()
    {
        if ($this->gender == 'male') {
            return false;
        }
    }
}
