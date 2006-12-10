<?php

$start_time = microtime(true);

set_time_limit(0);

define('POPULATION', 100000);

require_once 'config.php';

$names__male = array();
$names_female = array();
$names_last = array();

class Name extends Zend_Db_Table {};
class Person extends Zend_Db_Table {};

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
	$person->nameFirst = $first_name;
	$person->nameLast = $last_name;
	$person->gender = $gender;
	$now = time();
	$date_birth = mt_rand(0, $now);
	$date_death = mt_rand($now, mt_getrandmax());
	$person->dateBirth = date('Y-m-d', $date_birth);
	$person->dateDeath = date('Y-m-d', $date_death);
	$person->save();
}

$total_time = microtime(true) - $start_time;
echo 'Processed ' . $i . ' records in  ' . $total_time . ' seconds (' . $i/$total_time . ' records per second)' . "\n";
