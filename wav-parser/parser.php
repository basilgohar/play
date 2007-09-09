<?php

require_once 'lib.php';

ini_set('memory_limit', '1G');

define('FILENAME', 'Waleed Basyouni - Conquer Your Fear - Khutbah - Raw - trimmed.wav');

$clip_difference = 60000;

if (! file_exists(FILENAME)) {
	throw new Exception('File ' . FILENAME . ' does not exist!');
}

if (! $file = file_get_contents(FILENAME)) {
	throw new Exception('Could not load file ' . FILENAME);
}

$length = strlen($file);

echo 'File is ' . number_format($length) . ' bytes long' . "\n";

$i = strpos($file, 'data') + 4;

$last_sample = 0;
$sample_count = 0;

$clipping = false;

//$histogram = array();

$clipped_samples = array();

while ($i < $length) {
    $current_sample_raw = substr($file, $i, 2);
    $current_sample_array = unpack('s', $current_sample_raw);
    $current_sample = $current_sample_array[1];
    
    /*
    if (! isset($histogram[$current_sample])) {
        $histogram[$current_sample] = 0;
    }
    
    ++$histogram[$current_sample];
	*/
    
    if (abs($last_sample - $current_sample) > $clip_difference) {        
        if (false === $clipping) {
            $clipping = true;
            echo 'Possibly-clipped segment detected' . "\n";
            $clipped_sample_segment = array();
        }
        $clipped_sample_segment[$sample_count - 1] = $last_sample; 
        echo "\t" . ($sample_count - 1) . "\t" . $last_sample . "\n";
    } else {
        if (true === $clipping) {
            $clipped_samples[] = $clipped_sample_segment;
            $clipping = false;
            echo 'Possibly-clipped segment concluded' . "\n";
        }
    }
    
    $last_sample = $current_sample;
    
    $i += 2;
    ++$sample_count;
}
/*
ksort($histogram);

print_r($histogram);
*/

print_r($clipped_samples);
