<?php

$count = 100000000;
$string = 'a';

while ($count > 0) {
    echo md5($string) . "\t" . $string . "\n";
    ++$string;
    --$count;
}
