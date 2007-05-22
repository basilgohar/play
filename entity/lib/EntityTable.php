<?php

require_once 'Zend/Db/Table.php';

class EntityTable extends Zend_Db_Table_Abstract
{
    protected $_name = 'entity';
}
