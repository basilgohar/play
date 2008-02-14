<?php

$start_time = microtime(true);

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once 'config.php';
set_time_limit(0);

$people_ids = $db->fetchCol("SELECT `id` FROM `People`");

$i = count($people_ids);

$people = new People();

foreach ($people_ids as $person_id) {
    $name = (string) $people->fetchRow("`id` = $person_id") . "\n";
}

$total_time = microtime(true) - $start_time;
echo 'Processed ' . $i . ' records in  ' . $total_time . ' seconds (' . $i/$total_time . ' records per second)' . "\n";
