<?php

require_once 'config.php';

$person_table = new PersonTable();

/*
foreach ($person_table->fetchAll() as $person) {
    echo $person;
    echo "\n";
}
*/

$sql = "SELECT p.id FROM `person` p JOIN `name` name_first ON p.name_first_id = name_first.id JOIN `name` name_last ON p.name_last_id = name_last.id ORDER BY name_last.value ASC , name_first.value ASC";

$result = $db->fetchCol($sql);

foreach ($result as $person_id) {
    $person = $person_table->fetchRow("`id` = $person_id");
    echo $person;
    echo "\n";
}
