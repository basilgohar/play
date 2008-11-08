<?php

require_once 'lib.php';

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

$data_offset = strpos($file, 'data') + 4;

$i = $data_offset;

$last_sample = 0;
$sample_count = 0;

$clipping = false;

//$histogram = array();

$clipped_samples = array();

while ($i < $length) {
    //echo $i . "\n";
    
    //$current_sample = wave_extract_sample($file, $i);
    
    $current_sample = current(unpack('s', substr($file, $i, 2)));
    
    //$current_sample = wave_extract_sample('file', $i);
    
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
            $clipped_sample_segment[$sample_count - 1] = $last_sample;
            if (! (abs($current_sample) > CLIP_THRESHHOLD)) {
                //  Clipped segment appears to have concluded
                $clipped_samples[] = $clipped_sample_segment;
                $clipping = false;
                echo 'Possibly-clipped segment concluded' . "\n";
            }
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

foreach ($clipped_samples as $clipped_sample_segment) {
    //print_r($clipped_sample_segment);
    $first_sample_in_segment = current($clipped_sample_segment);
    $packed_form = pack('s', $first_sample_in_segment);
    //echo 'First sample: ' . $first_sample_in_segment . "\n";
    
    foreach ($clipped_sample_segment as $sample_position => $sample_value) {        
        $file_position_index = $data_offset + $sample_position * 2;
        $file[$file_position_index] = $packed_form[0];
        $file[$file_position_index + 1] = $packed_form[1];
    }
}

file_put_contents(FILENAME . '.parsed', $file);
