<?php

$start_time = microtime(true);

require_once '../config.inc.php';

set_time_limit(0);

define('POPULATION', 1000000);

$names_male = array();
$names_female = array();
$names_last = array();

class name extends Zend_Db_Table {};
class person extends Zend_Db_Table {};

$name_table = new Name();
$person_table = new Person();

$db->query('TRUNCATE TABLE `person`');

$names = $name_table->fetchAll();
foreach ($names as $name) {
	switch ($name->type) {
		default:
			break;
		case 'male':
			$names_male[] = $name->value;
			break;
		case 'female':
			$names_female[] = $name->value;
			break;
		case 'last':
			$names_last[] = $name->value;
			break;
	}
}

sort($names_male);
sort($names_female);
sort($names_last);

$names_male_count = sizeof($names_male);
$names_female_count = sizeof($names_female);
$names_last_count = sizeof($names_last);
$genders = array('male', 'female');

for ($i = 0; $i < POPULATION; $i++) {
	$gender = $genders[mt_rand(0, 1)];
	if ($gender == 'male') {
		$first_name = mt_rand(0, $names_male_count - 1);
	} else {
		$first_name = mt_rand(0, $names_female_count - 1);
	}
	$last_name = mt_rand(0, $names_last_count - 1);

	$person = $person_table->fetchNew();
	$person->name_first = $first_name;
	$person->name_last = $last_name;
	$person->gender = $gender;	
	$person->save();
}

$total_time = microtime(true) - $start_time;
echo 'Processed ' . $i . ' records in  ' . $total_time . ' seconds (' . $i/$total_time . ' records per second)' . "\n";

