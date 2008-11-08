<?php

class Soldier
{
    protected $stats = array();

    public function __construct($rank = null)
    {
        $this->stats['life'] = 100;
        $this->stats['strength'] = mt_rand(80, 120);
        $this->stats['dexterity'] = mt_rand(80, 120);
        $this->stats['agility'] = mt_rand(80, 120);
    }

    public function getStat($stat)
    {
        if (isset($this->stats[$stat])) {
            return $this->stats[$stat];
        } else {
            return false;
        }
    }

    protected function setStat($stat, $value)
    {
        if (isset($this->stats[$stat])) {
            $this->stats[$stat] = $value;
            return true;
        } else {
            return false;
        }
    }
}
