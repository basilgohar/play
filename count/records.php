<?php

define('SET_SIZE', 10000);
define('COUNT', 1000000000);
define('RECORDS_FILENAME', 'records');

$values = array();

for ($i = 0; $i < SET_SIZE; ++$i) {
    $values[] = mt_rand();
}

$fp = fopen(RECORDS_FILENAME, 'w');

for ($i = 0; $i < COUNT; ++$i) {
    fwrite($fp, $values[mt_rand(0, SET_SIZE - 1)] . "\n");
}
