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
                return (count($this->getSpouses()) < 4);
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
        if ($this->gender === $potential_spouse->gender) {
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
        return count($this->getSpouses()) > 0;
    }
    
    public function hasChildren()
    {
        return count($this->getChildren()) > 0;
    }

    /**
     * Returns a rowset containing all the children
     * of this person, if any
     *
     */
    public function getChildren()
    {
        if ('male' === $this->gender) {
            $field_name = 'father_id';
        } else {
            $field_name = 'mother_id';
        }
        
        $family_table = new FamilyTable();
        $families = $family_table->fetchAll("`$field_name` = $this->id");
        
        if (count($families) > 0) {
            $child_ids = array();
            foreach ($families as $family) {
                $child_ids[] = $family->person_id;
            }
            $person_table = new PersonTable();
            $this->children = $person_table->fetchAll('`id` IN (' . implode(',', $child_ids) . ')');
        }
        
        return $this->children;
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
        //if (null === $this->spouses) {
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
            if (count($marriages) > 0) {
                $spouse_ids = array();
                foreach ($marriages as $marriage) {
                    $spouse_ids[] = $marriage->$other_partner_field;
                }
                $person_table = new PersonTable();
                $this->spouses = $person_table->fetchAll('`id` IN (' . implode(',', $spouse_ids) . ')');
            }            
        //}        
        return $this->spouses;
    }
    
    
    /*
    public function getSpouses()
    {
        return $this->findPersonTableViaMarriageTable();
    }
    */

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
        
        $name_table = new NameTable();
        
        $name_first = $name_table->fetchRandom($child_gender)->value;        
        
        $person_table = new PersonTable();
        
        $child = $person_table->fetchNew();
        $child->name_first = $name_first;
        $child->name_last = $father->name_last;
        $child->gender = $child_gender;
        $child->date_birth = date('Y-m-d H:i:s');
        $child->date_death = '';
        
        $child->save();
        
        $family_table = new FamilyTable();
        $family_record = $family_table->fetchNew();
        
        $family_record->person_id = $child->id;
        $family_record->mother_id = $this->id;
        $family_record->father_id = $father->id;
        
        $family_record->save();
        
        return $child;
    }
}
