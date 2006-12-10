<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('FILE_NAME_MALE', 'dist.male.first');
define('FILE_NAME_FEMALE', 'dist.female.first');
define('FILE_NAME_LAST', 'dist.all.last');

$types = array('male' => FILE_NAME_MALE, 'female' => FILE_NAME_FEMALE, 'last' => FILE_NAME_LAST);

require_once 'Zend/Db.php';
require_once 'Zend/Db/Table.php';

$params = array(
	'host' => 'localhost',
	'username' => 'abu_hurayrah',
	'password' => 'regnis',
	'dbname' => 'abu_hurayrah'
);

$db = Zend_Db::factory('PDO_MYSQL', $params);
Zend_Db_Table::setDefaultAdapter($db);

class Name extends Zend_Db_Table {};
$name_table = new Name();

$db->query('TRUNCATE TABLE `name`');

foreach ($types as $type => $filename) {
	if (!$fp = fopen($filename, 'r')) {
		trigger_error('Could not open file ' . $filename, E_USER_WARNING);
		continue;
	}

	while (($line = fgets($fp)) !== false) {
		$normalized_line = preg_replace('/ +/', ' ', $line);
		$values = explode(' ', $normalized_line);
		//print_r($values);
		$name = $name_table->fetchNew();
		$name->value = $values[0];
		$name->frequency = $values[1];
		$name->cumulativeFrequency = $values[2];
		$name->rank = $values[3];
		$name->type = $type;
		$name->save();
	}
}

