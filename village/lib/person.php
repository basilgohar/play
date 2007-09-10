<?php

require_once 'Zend/Db/Table/Row.php';

class Person extends Zend_Db_Table_Row
{
    protected $spouses = null;
    protected $children = null;
    
    protected $mother = null;
    protected $father = null;
    
    protected $marriage_field_name = '';
    protected $family_field_name = '';
    
    protected $name_first = null;
    protected $name_last = null;
    
    public function getNameValue($type)
    {
        switch ($type) {
            default:
                throw new Exception('Invalid name type "' . $type . '" specified');
                break;
            case 'first':
                $name = $this->findParentRow('Names', 'FirstName');
                break;
            case 'last':
                $name = $this->findParentRow('Names', 'LastName');
                break;
        }
        return $name->value;
    }
    
    public function getNameFirst()
    {
        return $this->getNameValue('first');
    }
        
    public function getNameLast()
    {
        return $this->getNameValue('last');
    }

    public function getFullName()
    {
        return $this->getNameFirst() . ' ' . $this->getNameLast();
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
                return (count($this->getSpouses()) < VILLAGE_SPOUSE_MAX_MALE);
                break;
            case 'female':
                return (count($this->getSpouses()) < VILLAGE_SPOUSE_MAX_FEMALE);
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
        if ($this->gender === $potential_spouse->gender) {
            //  Not in this state!
            return false;
        }
        
        return $this->isEligableForMarriage() && $potential_spouse->isEligableForMarriage();
    }
    
    public function marryTo(Person $spouse)
    {
        if (! $this->canMarry($spouse)) {
            return false;
        }
        
        $marriage_table = new Marriages();
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
        return count($this->getSpouses()) > 0;
    }
    
    public function hasChildren()
    {
        return count($this->getChildren()) > 0;
    }

    public function getChildren()
    {
        if ('male' === $this->gender) {
            $parent_role = 'Father';
        } else {
            $parent_role = 'Mother';
        }
        return $this->findManyToManyRowset('People', 'Families', $parent_role, 'Child');
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
        return count($this->getSpouses());
    }

    public function getSpouses()
    {
        if ('male' === $this->gender) {
            $marriage_role = 'Husband';
            $spouse_role = 'Wife';
        } else {
            $marriage_role = 'Wife';
            $spouse_role = 'Husband';
        }
        return $this->findManyToManyRowset('People', 'Marriages', $marriage_role, $spouse_role);
    }

    public function haveChild()
    {
        if ('female' !== $this->gender) {
            return false;
        }
        
        if (! $this->isMarried()) {
            return false;
        }
        
        foreach ($this->getSpouses() as $father) {
            //  Creates the $father variable
            ;
        }

        (0 === mt_rand(0,1)) ? $child_gender = 'male' : $child_gender = 'female';
        
        $name_table = new Names();
        
        $name_first_id = $name_table->fetchRandom($child_gender)->id;        
        
        $person_table = new People();
        
        $child = $person_table->fetchNew();
        $child->name_first_id = $name_first_id;
        $child->name_last_id = $father->name_last_id;
        $child->money = 100;
        $child->gender = $child_gender;
        $child->money = 100;
        $child->date_birth = date('Y-m-d H:i:s');
        $child->date_death = '';
        
        $child->save();
        
        $family_table = new Families();
        $family_record = $family_table->fetchNew();
        
        $family_record->person_id = $child->id;
        $family_record->mother_id = $this->id;
        $family_record->father_id = $father->id;
        
        $family_record->save();
        
        return $child;
    }
    
    public function isBloodRelative(Person $person)
    {
        
    }
}
