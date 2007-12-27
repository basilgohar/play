<?php

require_once 'config.php';

$string = '';

$append_string = 'a';

$i = 0;

switch ($subtest) {
    default:
        exit('Invalid subtest "' . $subtest . '" specified' . "\n");
        break;
    case 'strlen':
        while (strlen($string) < $iterations) {
            $string .= $append_string;
            ++$i;
        }
        break;
    case 'isset':
        while(! isset($string{$iterations - 1})) {
            $string .= $append_string;
            ++$i;
        }
        break;
}
