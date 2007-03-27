<?php

require_once 'config.php';

define('FILE_NAME_MALE', 'dist.male.first');
define('FILE_NAME_FEMALE', 'dist.female.first');
define('FILE_NAME_LAST', 'dist.all.last');

$types = array('male' => FILE_NAME_MALE, 'female' => FILE_NAME_FEMALE, 'last' => FILE_NAME_LAST);

$name_table = new NameTable();

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
		$name->type = $type;
		$name->save();
	}
}
