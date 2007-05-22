<?php

require_once 'Zend/Controller/Action.php';

class SomethingController extends Zend_Controller_Action
{
    public function indexAction()
    {
        echo 'Hello from SomethingController';
    }

    public function somethingAction()
    {
        echo 'You must have done something';
    }

    public function noRouteAction()
    {
        echo "I don't think so...";
    }
}