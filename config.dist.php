<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$start_time = microtime(true);

define('ZF_PATH', '/usr/share/zend-framework/library');
define('VILLAGE_POPULATION', 1000);
define('VILLAGE_DISPLAY_LIMIT', 50);
define('VILLAGE_CONTROLLER_PATH', '/home/basil.gohar/public_html/play/village/controllers');
define('VILLAGE_SPOUSE_MAX_MALE', 4);
define('VILLAGE_SPOUSE_MAX_FEMALE', 1);

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
