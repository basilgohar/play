<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$start_time = microtime(true);

define('ZF_PATH', '/usr/share/zend-framework/library');

set_include_path(get_include_path() . PATH_SEPARATOR . ZF_PATH);

$CFG['db']['host'] = 'localhost';
$CFG['db']['username'] = 'play';
$CFG['db']['password'] = 'play';

require_once 'Zend/Db.php';
require_once 'Zend/Db/Table.php';

$db = Zend_Db::factory('PDO_MYSQL', $CFG['db']);
Zend_Db_Table::setDefaultAdapter($db);

$max_allowed_packet_array = current($db->query("SHOW VARIABLES LIKE 'max_allowed_packet'")->fetchAll());
$max_allowed_packet = $max_allowed_packet_array['Value'];
$max_sql_string_length = $max_allowed_packet - 10000;	//  Arbitrary value, really
