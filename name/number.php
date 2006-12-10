<?php

$number = pow(2, 64) - 100;

while (is_int($number)) {
    ++$number;
}

var_dump($number);
