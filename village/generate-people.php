<?php

$start_time = microtime(true);

require_once 'config.php';

set_time_limit(0);

$name_ids_male = array();
$name_ids_female = array();
$name_ids_last = array();

$names = new Names();

foreach ($names->fetchAll()->toArray() as $name) {
    switch ($name['type']) {
        default:
            break;
        case 'male':
            $name_ids_male[] = $name['id'];
            break;
        case 'female':
            $name_ids_female[] = $name['id'];
            break;
        case 'last':
            $name_ids_last[] = $name['id'];
            break;
    }
}

$names_male_count = count($name_ids_male);
$names_female_count = count($name_ids_female);
$names_last_count = count($name_ids_last);

$genders = array('male', 'female');

$now = date('Y-m-d H:i:s');

$sql = '';
$sql_array = array();
for ($i = 0; $i < VILLAGE_POPULATION; ++$i) {
    0 === mt_rand(0,1) ? $gender = 'male' : $gender = 'female';
    'male' === $gender ? $name_first_id = $name_ids_male[mt_rand(0, $names_male_count - 1)] : $name_first_id = $name_ids_female[mt_rand(0, $names_female_count - 1)];
    $name_last_id = $name_ids_last[mt_rand(0, $names_last_count - 1)];
	$person_array = array($name_first_id, $name_last_id, "'" . $now . "'", 0, "'" . $gender . "'");
	if ('' === $sql) {
		$sql = "INSERT INTO `People` (`name_first_id`,`name_last_id`,`date_birth`,`date_death`,`gender`) VALUES ";
	}
	$sql .= '(';
	$sql .= implode(',', $person_array);
	$sql .= '),';
	if (strlen($sql) > $max_sql_string_length) {
		$sql_array[] = substr($sql, 0, -1);
		$sql = '';
	}
}

if ('' !== $sql) {
	//  Process the last remaining SQL string
	$sql_array[] = substr($sql, 0, -1);	
	$sql = '';
}
$db->query('TRUNCATE TABLE `People`');
$db->query('ALTER TABLE `People` DISABLE KEYS');
$db->query('LOCK TABLES `People` WRITE');
foreach ($sql_array as $sql) {
	$db->query($sql);
}
$db->query('UNLOCK TABLES');
$db->query('ALTER TABLE `People` ENABLE KEYS');

$total_time = microtime(true) - $start_time;
echo 'Processed ' . $i . ' records in  ' . $total_time . ' seconds (' . $i/$total_time . ' records per second)' . "\n";
