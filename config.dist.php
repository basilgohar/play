<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('ZF_PATH', '/usr/share/zend-framework/library');
define('VILLAGE_POPULATION', 1000);
define('VILLAGE_DISPLAY_DEFAULT', 1000);

set_include_path(get_include_path() . PATH_SEPARATOR . ZF_PATH);

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
