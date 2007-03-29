<?php

require_once 'config.php';

$person_table = new PersonTable();

foreach ($person_table->fetchAll(null, null, 10) as $person) {
    foreach ($person->getSpouses() as $spouse) {
        var_dump($spouse);
    }
}