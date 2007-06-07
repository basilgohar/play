<?php

$start_time = microtime(true);

$count = 10000000000;
$string = 'a';
/*
while ($count > 0) {
    ++$string;
    --$count;
    ++$i;
}
*/

for ($i = 0; $i < $count; ++$i) {
    ++$string;
}

echo 'Final string: ' . $string . "\n";

$total_time = microtime(true) - $start_time;

echo 'Processed ' . number_format($i) . ' iterations in ' . number_format(round($total_time, 3)) . ' seconds (' . number_format($i/$total_time) . ' iterations/second)' . "\n";
