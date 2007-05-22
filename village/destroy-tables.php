<?php

require_once 'config.php';

$table_names = array('marriage', 'family', 'person', 'name');

foreach ($table_names as $table_name) {
    $sql = "DROP TABLE IF EXISTS `" . $table_name . "`";
    $db->query($sql);
}
