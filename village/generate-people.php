<?php

$start_time = microtime(true);

require_once 'config.php';

set_time_limit(0);

$name_ids_male = array_values($db->fetchCol("SELECT `id` FROM `Names` WHERE `type` = 'male'"));
$name_ids_female = array_values($db->fetchCol("SELECT `id` FROM `Names` WHERE `type` = 'female'"));
$name_ids_last = array_values($db->fetchCol("SELECT `id` FROM `Names` WHERE `type` = 'last'"));
 
$names_male_count = count($name_ids_male);
$names_female_count = count($name_ids_female);
$names_last_count = count($name_ids_last);

$genders = array('male', 'female');

$now = date('Y-m-d H:i:s');

$db->query('TRUNCATE TABLE `People`');
$db->query('ALTER TABLE `People` DISABLE KEYS');

$sql = '';
$village_population = VILLAGE_POPULATION;
$i = 0;
while ($i < $village_population) {
    ++$i;
    0 === mt_rand(0,3) ? $gender = 'male' : $gender = 'female';
    'male' === $gender ? $name_first_id = $name_ids_male[mt_rand(0, $names_male_count - 1)] : $name_first_id = $name_ids_female[mt_rand(0, $names_female_count - 1)];
    $name_last_id = $name_ids_last[mt_rand(0, $names_last_count - 1)];
	$person_array = array($name_first_id, $name_last_id, "'$now'", 0, "'$gender'");
	if ('' === $sql) {
		$sql = "INSERT INTO `People` (`name_first_id`,`name_last_id`,`date_birth`,`date_death`,`gender`) VALUES ";
	}
	$sql .= '(';
	$sql .= implode(',', $person_array);
	$sql .= '),';
    if (isset($sql{$max_sql_string_length})) {
        $sql = substr($sql, 0, -1);
        $db->query($sql);
        $sql = '';
    }
}

if ('' !== $sql) {
	//  Process the last remaining SQL string
	$sql = substr($sql, 0, -1);
	$db->query($sql);	
	$sql = '';
}
$db->query('ALTER TABLE `People` ENABLE KEYS');

$total_time = microtime(true) - $start_time;
echo 'Processed ' . $i . ' records in  ' . $total_time . ' seconds (' . $i/$total_time . ' records per second)' . "\n";
