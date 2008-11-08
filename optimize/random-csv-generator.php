<?php

if (! file_exists('/usr/share/dict/words')) {
    throw new Exception('Words file does not exist');
}

$words = file('/usr/share/dict/words');

define('WORD_COUNT', count($words));
define('COUNT', 1000000);
define('FIELDS_COUNT', 8);
define('OUTFILE', 'outfile.csv');

if (! $fp = fopen(OUTFILE, 'w')) {
    throw new Exception('Could not open outfile "' . OUTFILE . '"');
}

for ($i = 0; $i < COUNT; ++$i) {
    $row = array();
    for ($j = 0; $j < FIELDS_COUNT; ++$j) {
        $random_word = trim($words[mt_rand(0, WORD_COUNT - 1)]);
        $row[] = $random_word;
    }
    fputcsv($fp, $row);    
}

fclose($fp);

