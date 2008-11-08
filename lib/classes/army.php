<?php

class Army
{
    protected $soldiers = array();

    public function __construct()
    {

    }

    public function addSoldier(Soldier $soldier)
    {
        $this->soldiers[] = $soldier;
    }

    public function getSoldier($id)
    {
        if (isset($this->soldiers[$id])) {
            return $this->soldiers[$id];
        } else {
            return false;
        }
    }

    public function removeSoldier($id)
    {
        if (isset($this->soldiers[$id])) {
            unset($this->soldiers[$id]);
        }
    }

    public function getNextSoldier()
    {
        return next($this->soldiers);
    }
}
