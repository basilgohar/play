<?php

$start_time = microtime(true);

require_once 'config.php';

set_time_limit(0);

$name_ids_male = array();
$name_ids_female = array();
$name_ids_last = array();

$db->query('TRUNCATE TABLE `People`');

$names = new Names();
$people = new People();

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

$db->beginTransaction();
for ($i = 0; $i < VILLAGE_POPULATION; ++$i) {
    0 === mt_rand(0,1) ? $gender = 'male' : $gender = 'female';
    'male' === $gender ? $name_first_id = $name_ids_male[mt_rand(0, $names_male_count - 1)] : $name_first_id = $name_ids_female[mt_rand(0, $names_female_count - 1)];
    $name_last_id = $name_ids_last[mt_rand(0, $names_last_count - 1)];
    $person = $people->fetchNew();
    $person->name_first_id = $name_first_id;
    $person->name_last_id = $name_last_id;
    $person->date_birth = $now;
    $person->date_death = 0;
    $person->gender = $gender;
    $person->save();    
}
$db->commit();

$total_time = microtime(true) - $start_time;
echo 'Processed ' . $i . ' records in  ' . $total_time . ' seconds (' . $i/$total_time . ' records per second)' . "\n";
