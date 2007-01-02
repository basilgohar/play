<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

set_include_path(get_include_path() . PATH_SEPARATOR . '/usr/share/zend-framework/library');

$CFG = array();

$CFG['db'] = array (
	'host' => 'localhost',
	'username' => 'play',
	'password' => 'play',
	'dbname' => 'play'
);

require_once 'Zend/Db.php';
require_once 'Zend/Db/Table.php';

$db = Zend_Db::factory('PDO_MYSQL', $CFG['db']);
Zend_Db_Table::setDefaultAdapter($db);
