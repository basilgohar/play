<?php

require_once 'count.inc.php';

$i = 0;
while ($i < COUNT) {
	++$i;
}

$total_time = microtime(true) - $start_time;

echo 'Processed ' . COUNT . ' iterations in ' . $total_time . ' seconds (' . (COUNT/$total_time) . ' iterations/second)' . "\n";

