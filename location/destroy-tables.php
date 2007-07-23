<?php

require_once 'config.php';
require_once 'tables.php';

foreach (array_keys($db_tables) as $table_name) {
    $db->query("DROP TABLE IF EXISTS `$table_name`");
}
