<?php

$start_time = microtime(true);

$count = 100000;
$string = 'a';

require_once 'config.php';

$db->query('TRUNCATE TABLE `hash`');

$sql = '';

for ($i = 0; $i < $count; ++$i) {
    $sql = "INSERT INTO `hash` VALUES ('" . $string . "','" . md5($string) . "')";
    $db->query($sql);
    ++$string;
}

$total_time = microtime(true) - $start_time;

echo 'Final string: ' . $string . "\n";
echo 'Processed ' . $count . ' iterations in ' . $total_time . ' seconds (' . $count/$total_time . ' iterations/second)' . "\n";
