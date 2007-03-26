<?php

require_once 'Zend/Db/Table.php';

class AncestryTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'ancestry';
}

class MarriageTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'marriage';
}

class NameTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'name';
}

class PersonTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'person';
    protected $_rowClass = 'Person';
}
