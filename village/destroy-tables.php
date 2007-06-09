<?php

require_once 'config.php';

$table_names = array('Marriages', 'Families', 'People', 'Names');

foreach ($table_names as $table_name) {
    $sql = "DROP TABLE IF EXISTS `" . $table_name . "`";
    $db->query($sql);
}
