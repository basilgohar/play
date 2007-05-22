<?php

require_once 'Zend/Controller/Action.php';

class AnotherController extends Zend_Controller_Action
{
    public function indexAction()
    {
        echo 'Hello from AnotherController';
    }

    public function blahAction()
    {
        echo "Blah";
    }
    
}