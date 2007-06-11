<?php

$i = 0;
$max = 1000000;
$random = array();

//while (++$i < $max) {
for ($i = 0; $i < $max; ++$i) {
    $random[] = mt_rand(0, $max);
}

sort($random);

//print_r($random);
