<?php

$start_time = microtime(true);

set_time_limit(0);

require_once 'config.default.php';

$people = new People();
$eligable_women_ids = $people->fetchPeopleEligableForMarriage('female');
$eligable_men_ids = $people->fetchPeopleEligableForMarriage('male');

$eligable_women_count = count($eligable_women_ids);
$eligable_men_count = count($eligable_men_ids);

shuffle($eligable_women_ids);
shuffle($eligable_men_ids);

$sql_string = '';
$sql_array = array();

for ($i = 0; $i < $eligable_women_count; ++$i) {
    $eligable_woman_id = $eligable_women_ids[$i];
    if ($i < $eligable_men_count) {
        $eligable_man_id = $eligable_men_ids[$i];
    } else {
        break;
    }
    $values = array($eligable_man_id, $eligable_woman_id, "'" . date('Y-m-d H:i:s') . "'", "''");
    if ('' === $sql_string) {
        $sql_string = "INSERT INTO `Marriages` (`husband_id`,`wife_id`,`date_married`,`date_divorced`) VALUES ";
    }
    $sql_string .= '(';
    $sql_string .= implode(',', $values);
    $sql_string .= '),';
    if (strlen($sql_string) > $max_sql_string_length) {
        $sql_array[] = substr($sql_string, 0, -1);
        $sql_string = '';
    }
}

if ('' !== $sql_string) {
    $sql_array[] = substr($sql_string, 0, -1);
    $sql_string = '';
}

$db->query('ALTER TABLE `Marriages` DISABLE KEYS');
foreach ($sql_array as $sql_string) {
    $db->query($sql_string);
}
$db->query('ALTER TABLE `Marriages` ENABLE KEYS');

/*
foreach ($people->fetchAll("`gender` = 'female'", 'RAND()') as $female) {
    //$engaged_couples[] = array('female' => $female, 'male' => $people->fetchRow("`gender` = 'male'", 'RAND()'));
	$male = $people->fetchRow("`gender` = 'male'", 'RAND()');
    if ($female->marryTo($male)) {
        //echo 'Successfully married ';
        //echo $female;
        //echo ' to ';
        //echo $male;
        //echo "\n";
    }
	
}
*/
/*
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
*/