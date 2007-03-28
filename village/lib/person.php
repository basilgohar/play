<?php

require_once 'Zend/Db/Table/Row.php';

class Person extends Zend_Db_Table_Row
{
    public function getFullName()
    {
        return $this->name_first . ' ' . $this->name_last;
    }
    
    public function __toString()
    {
        return $this->getFullName() . ' (' . $this->id . ')';
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
                return ($result->count() < 4);
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
            $marriage->husband_id = $this->id;
            $marriage->wife_id = $spouse->id;
        } else {
            $marriage->wife_id = $this->id;
            $marriage->husband_id = $spouse->id;
        }
        
        $marriage->date_married = date('Y-m-d');
        $marriage->date_divorced = '';
        
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
    
    public function hasChildren()
    {
        return false;
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
    
    public function getSpouseCount()
    {
        $marriage_table = new MarriageTable();
        ('male' === $this->gender) ? $where = '`husband_id` = ' . $this->id : $where = '`wife_id` = ' . $this->id;
        return count($marriage_table->fetchAll($where));
    }
    
    public function getSpouses()
    {
        if (! $this->isMarried()) {
            return false;
        }
        
        if ('male' === $this->gender) {
            $partner_field = 'husband_id';
            $other_partner_field = 'wife_id';
        } else {
            $partner_field = 'wife_id';
            $other_partner_field = 'husband_id';
        }        
        $marriage_table = new MarriageTable();        
        $where = '`' . $partner_field . '` = ' . $this->id;
        $marriages = $marriage_table->fetchAll($where);
        $spouse_ids = array();
        foreach ($marriages as $marriage) {
            $spouse_ids[] = $marriage->$other_partner_field;
        }
        
        $person_table = new PersonTable();
        return $person_table->fetchAll('`id` IN (' . implode(',', $spouse_ids) . ')');
    }
    
    public function getSpouse($number = 1)
    {
        if (! $this->isMarried()) {
            return false;
        }
        
        $marriage_table = new MarriageTable();
        ('male' === $this->gender) ? $where = '`husband_id` = ' . $this->id : $where = '`wife_id` = ' . $this->id;
        $marriages = $marriage_table->fetchAll($where)->toArray();
        
        if ($number > count($marriages) + 1) {
            return false;
        } else {
            return $marriages[$number - 1];
        }
    }
    
    public function isPregnant()
    {
        if ($this->gender == 'male') {
            return false;
        }
    }
}
