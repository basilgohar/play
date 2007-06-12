<?php

require_once 'config.php';

foreach ($tables_sql as $table_name => $table_sql) {
    $db->query($table_sql);
}
