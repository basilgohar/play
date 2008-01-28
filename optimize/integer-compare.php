<?php

$i = PHP_INT_MAX - 1000000000;

while ( (int) $i === $i) {
    ++$i;
}

echo $i;
