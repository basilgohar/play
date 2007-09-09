<?php

require_once 'lib.php';

$values = range(-10, 10);

foreach ($values as $value) {
    echo $value . "\t" . twos_complement_int($value) . "\n";
}
