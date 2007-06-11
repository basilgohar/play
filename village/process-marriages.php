<?php

$start_time = microtime(true);

set_time_limit(0);

require_once 'config.php';

$people = new People();
$eligable_women = $people->fetchPeopleEligableForMarriage('female');
$eligable_men = $people->fetchPeopleEligableForMarriage('male');

foreach ($eligable_women as $eligable_woman) {
	$eligable_woman->marryTo(current($eligable_men));
	$eligable_men->next();
}

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