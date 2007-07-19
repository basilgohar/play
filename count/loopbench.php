<?php

require_once 'count.inc.php';

$count = COUNT;

echo 'Attempting ' . COUNT . ' iterations of ' . TEST . ' test'. "\n";

switch (TEST) {
    case 'while':
        while ($i < $count) {
            ++$i;
        }
        break;
    case 'for':
        for ($i = 0; $i < COUNT; ++$i) {
            ;
        }
        break;
}

$total_time = microtime(true) - $start_time;

echo 'Processed ' . number_format((float) $i) . ' iterations in ' . $total_time . ' seconds (' . $i/$total_time . ' iterations/second)' . "\n";
