<?php

$start_time = microtime(true);

set_time_limit(0);

require_once 'config.php';

$person_table = new PersonTable();

$people = $person_table->fetchAll();
/*
$people = $person_table->fetchPeopleEligableForMarriage();
print_r($people);
exit;
*/
$persons = array();

foreach ($people as $person) {
    //  Only include those that are actually available for marriage
    if ($person->isEligableForMarriage()) {
        $persons[] = $person;
    }
}

unset($people);

$population_size = sizeof($persons);

foreach ($persons as $index => $person) {
    $random_value = $index;
    while ($random_value == $index) {
        $random_value = mt_rand(0, $population_size - 1);
    }
    $random_person = $persons[$random_value];
    if ($person->canMarry($random_person)) {
        if ($person->marryTo($random_person)) {
            echo 'Successfully married ';
            echo $person;
            echo ' to ';
            echo $random_person;
            echo "\n";
            if (! $person->isEligableForMarriage()) {
                //  Remove the person from the listing of eligable people
                //  & rebuild the array & size
                unset($persons[$index]);
                $persons = array_values($persons);
                $population_size = sizeof($persons);
            }
        }
    }
}
