<?php

require_once 'count.inc.php';

echo 'Test case: ' . TEST . "\n";
echo 'Total count: ' . number_format(COUNT) . "\n";

switch (TEST) {
    case 'while':
        $i = 0;
        while ($i < COUNT) {
            ++$i;
        }    
        break;
    case 'for':
        for ($i = 0; $i < COUNT; ++$i) {
            ;
        }    
        break;
    default:
        throw new Exception('Invalid test "' . TEST . '" specified');
        break;
}

$total_time = microtime(true) - $start_time;

echo 'Processed ' . number_format(COUNT) . ' iterations in ' . number_format($total_time, 2) . ' seconds (' . number_format((COUNT/$total_time), 2) . ' iterations/second)' . "\n";

