<?php

define('SIDE', 100);

require_once 'config.inc.php';

$count = 0;
$queries = 0;
$total = 0;

$db->query('TRUNCATE TABLE `Cell`');

$celltype_ids = array();
foreach ($db->query('SELECT `id` FROM `Celltype`')->fetchAll() as $celltype_id) {
    $celltype_ids[] = $celltype_id['id'];
}
$queries++;
$celltype_ids_count = count($celltype_ids);
$sql = '';
$db->query('ALTER TABLE `Cell` DISABLE KEYS');

//  Since they are both data as well as counter variables, we offset them by 1
$z = $y = $x = 0;

while ($z < SIDE) {
    while ($y < SIDE) {
        while ($x < SIDE) {
            if (strlen($sql) > $max_sql_string_length) {
                //  The SQL string is getting too long, so flush the query
                $db->query($sql);
                $sql = '';
                $queries++;
            }
            
            //  Fetch a random celltype
            $celltype_id = $celltype_ids[mt_rand(0, $celltype_ids_count - 1)];
                        
            if ('' === $sql) {
                //  We are either starting or we've just flushed the SQL string
                $sql = "INSERT INTO `Cell` (`type_id`,`coord_x`,`coord_y`,`coord_z`) VALUES ($celltype_id,$x,$y,$z)";
            } else {
                //  Simply append a new set of values to the end of the SQL string
                $sql .= ",($celltype_id,$x,$y,$z)";
            }
            $count++;
            ++$x;
        }
        $x = 0;
        ++$y;
    }
    $y = 0;
    ++$z;
}
$z = 0;

if (strlen($sql) > 0) {
    //  Flush the remain SQL string
    $db->query($sql);
    $sql = '';
    $queries++;
}

$db->query('ALTER TABLE `Cell` ENABLE KEYS');
$total_time = microtime(true) - $start_time;

echo 'Finished ' . $count . ' iterations in ' . $total_time . ' seconds with ' . $queries . ' queries (' . ($count/$total_time)  . ' iterations per second)' . "\n";
echo $total;