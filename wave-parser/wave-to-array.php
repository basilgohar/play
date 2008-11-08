<?php

require_once 'lib.php';

define('FILENAME', 'Waleed Basyouni - Conquer Your Fear - Khutbah - Raw - trimmed.wav');

if (! file_exists(FILENAME)) {
    throw new Exception('File ' . FILENAME . ' does not exist!');
}

print_r(wave_to_array(file_get_contents(FILENAME)));
