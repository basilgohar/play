<?php

$start_time = microtime(true);
/*
$pid = pcntl_fork();

if ($pid == -1) {
     die('could not fork');
} else if ($pid) {
     // we are the parent
} else {
     // we are the child
}
*/
require_once 'config.php';

set_time_limit(0);

$names_male = array_values($db->fetchCol("SELECT `value` FROM `Names` WHERE `type` = 'male'"));
$names_female = array_values($db->fetchCol("SELECT `value` FROM `Names` WHERE `type` = 'female'"));
$names_last = array_values($db->fetchCol("SELECT `value` FROM `Names` WHERE `type` = 'last'"));
 
$names_male_count = count($names_male);
$names_female_count = count($names_female);
$names_last_count = count($names_last);

$genders = array('male', 'female');

$now = date('Y-m-d H:i:s');

$db->query('TRUNCATE TABLE `People`');
$db->query('ALTER TABLE `People` DISABLE KEYS');

$sql = '';
//$village_population = VILLAGE_POPULATION/CPUS;
$village_population = VILLAGE_POPULATION;
$i = 0;

while ($i < $village_population) {
    ++$i;
    0 === mt_rand(0,3) ? $gender = 'male' : $gender = 'female';
    'male' === $gender ? $name_first = $names_male[mt_rand(0, $names_male_count - 1)] : $name_first = $names_female[mt_rand(0, $names_female_count - 1)];
    $name_last = $names_last[mt_rand(0, $names_last_count - 1)];
    $person_array = array($name_first, $name_last, $now, 0, $gender);
    if ('' === $sql) {
        $sql = "INSERT INTO `People` (`name_first`,`name_last`,`date_birth`,`date_death`,`gender`) VALUES ";
    }
    $sql .= "('";
    $sql .= implode("','", $person_array);
    $sql .= "'),";
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

if (isset($pid)) {
    //  Handle the keys differently for multi-processing
    if ($pid > 0) {
        //  Wait for all child processes to exit
        pcntl_wait($status);
        //  Only enable keys from the main process, once all others are done
        $db->query('ALTER TABLE `People` ENABLE KEYS');
    }    
} else {
    //  Enable keys at the end
    $db->query('ALTER TABLE `People` ENABLE KEYS');
}

$total_time = microtime(true) - $start_time;
echo 'Processed ' . $i . ' records in  ' . $total_time . ' seconds (' . $i/$total_time . ' records per second)' . "\n";
