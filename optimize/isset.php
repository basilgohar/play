<?php

$array = array('one' => 'two', 'three' => 'four');

$key = 'three';

$i = 0;

switch ($subtest) {
    default:
        exit('Invalid subtest "' . $subtest . '" specified' . "\n");
        break;
    case 'isset':
        while ($i < $iterations) {
            ++$i;
            if (isset($array[$key])) {
                ;
            }
        }
        break;
    case 'array_key_exists':
        while ($i < $iterations) {
            ++$i;
            if (array_key_exists($key, $array)) {
                ;
            }
        }
        break;
    case 'null':
        while ($i < $iterations) {
            ++$i;
            if (null === $array[$key]) {
                ;
            }
        }
        break;
}
