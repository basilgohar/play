<?php

class Battlefield
{
    protected $armies = array();

    public function __construct()
    {

    }

    public function addArmy(Army $army)
    {
        $this->armies[] = $army;
    }

    public function startBattle()
    {

    }
}
