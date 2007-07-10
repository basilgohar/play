<?php

define('SIDE', 180);

require_once 'config.inc.php';

$count = 0;
$queries = 0;

$db->query('TRUNCATE TABLE `Cell`');

$celltype_ids = array();
foreach ($db->query('SELECT `id` FROM `Celltype`')->fetchAll() as $celltype_id) {
    $celltype_ids[] = $celltype_id['id'];
}
$queries++;
$celltype_ids_count = count($celltype_ids);
$sql = '';
$db->query('ALTER TABLE `Cell` DISABLE KEYS');

for ($z = 1; $z <= SIDE; $z++) {
    for ($y = 1; $y <= SIDE; $y++) {
        for ($x = 1; $x <= SIDE; $x++) {
            $celltype_id = $celltype_ids[mt_rand(0, $celltype_ids_count - 1)];
            if ('' === $sql) {
                $sql = "INSERT INTO `Cell` (`type_id`,`coord_x`,`coord_y`,`coord_z`) VALUES ($celltype_id,$x,$y,$z)";
                $count++;
            } else {
                if (strlen($sql) > $max_sql_string_length) {
                    $db->query($sql);
                    $sql = '';
                    $queries++;
                } else {
                    $sql .= ",($celltype_id,$x,$y,$z)";
                    $count++;
                }
            }
        }
    }
}
if (strlen($sql) > 0) {
    $db->query($sql);
    $sql = '';
    $queries++;
}
$db->query('ALTER TABLE `Cell` ENABLE KEYS');
$total_time = microtime(true) - $start_time;

echo 'Finished ' . $count . ' iterations in ' . $total_time . ' seconds with ' . $queries . ' queries (' . ($count/$total_time)  . ' iterations per second)' . "\n";
