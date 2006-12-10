<?php

$params = array(
	'hostname' => 'localhost',
	'username' => 'abu_hurayrah',
	'password' => 'regnis',
	'dbname' => 'abu_hurayrah'
);

require_once 'Zend/Db.php';
require_once 'Zend/Db/Table.php';

$db = Zend_Db::factory('PDO_MYSQL', $params);
Zend_Db_Table::setDefaultAdapter($db);

require_once 'lib/Person.class.php';
require_once 'lib/PersonRowset.class.php';
require_once 'lib/PersonTable.class.php';
require_once 'lib/MarriageTable.class.php';
require_once 'lib/AncestryTable.class.php';
require_once 'lib/NameTable.class.php';
