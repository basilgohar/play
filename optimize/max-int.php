<?php

echo 'Maximum integer is: ' . number_format(PHP_INT_MAX) . "\n";
echo 'Integer size is: ' . PHP_INT_SIZE . "\n";

define('SIZE', 1000000);
$i = 0;
$j = 'a';

$size = SIZE;

$array = array();

while ($i < $size) {
    ++$i;
    ++$j;
    $array[$i] = $i;
}

//print_r($array);

echo memory_get_peak_usage();
