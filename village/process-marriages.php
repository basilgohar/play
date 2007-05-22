<?php

$start_time = microtime(true);

set_time_limit(0);

require_once 'config.php';

$person_table = new PersonTable();

$engaged_couples = array();

foreach ($person_table->fetchAll(null, 'RAND()') as $person) {    
    ('male' === $person->gender) ? $random_person_gender = 'female' : $random_person_gender = 'male';    
    $random_person = $person_table->fetchRow("`gender` = '$random_person_gender'", 'RAND()');    
    $engaged_couples[] = array($person->gender => $person, $random_person_gender => $random_person);
}


if (count($engaged_couples) > 0) {
    $db->beginTransaction();
    foreach ($engaged_couples as $engaged_couple) {
        if ($engaged_couple['female']->marryTo($engaged_couple['male'])) {
            echo 'Successfully married ';
            echo $engaged_couple['female'];
            echo ' to ';
            echo $engaged_couple['male'];
            echo "\n";
        }
    }
    $db->commit();
}
