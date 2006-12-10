<?php

require_once 'config.php';

$person_table = new PersonTable();

if (isset($_GET['person_id'])) {
    $person = $person_table->fetchRow("`id` = '" . $_GET['id'] . "'");
    print_r($person->toArray());
}

foreach ($person_table->fetchAll(null, 'name_last, name_first') as $person) {
    echo '<a href="?person_id=' . $person->id . '">';
    echo $person;
    echo '</a>';
    echo '<br />' . "\n";
}
