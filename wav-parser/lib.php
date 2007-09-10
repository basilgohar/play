<?php

ini_set('memory_limit', '2G');

define('CLIP_THRESHHOLD', 30000);

function wave_to_array(&$file)
{
    $data_offset = strpos($file, 'data') + 4;
    
    $i = $data_offset;
    
    $length = strlen($file);
    
    $wave_array = array('header' => substr($file, 0, $data_offset));
    
    while ($i < $length) {
        //  Save as integer
        $wave_array['samples'][] = current(unpack('s', substr($file, $i, 2)));
        
        //  Save as string
        //$wave_array['samples'][] = substr($file, $i, 2);
        
        $i += 2;
    }
    
    return $wave_array;
}

function wave_extract_sample(&$file, $offset)
{
    return current(pack('s', substr($file, $offset, 2)));
}
