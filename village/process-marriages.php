<?php

$start_time = microtime(true);

set_time_limit(0);

require_once 'config.php';

$person_table = new PersonTable();

foreach ($person_table->fetchAll() as $person) {
    if (! $person->isEligableForMarriage()) {
        continue;
    }
    $random_person = $person_table->fetchRow(null, 'RAND()', 1);
    if (! $person->isEligableForMarriage()) {
        continue;
    }
    if ($person->canMarry($random_person)) {
        if ($person->marryTo($random_person)) {
            echo 'Successfully married ';
            echo $person;
            echo ' to ';
            echo $random_person;
            echo "\n";
        }
    }
}
