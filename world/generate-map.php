<?php

define('XMAX', 200);
define('YMAX', 1000000);
define('MAPFILE', 'map');

$XMAX = XMAX;
$YMAX = YMAX;

if (! $fp = fopen(MAPFILE, 'w')) {
	throw new Exception('Could not open map file "' . MAPFILE . '"');
}

$land_types = array(
	'm' => 'mountain',
	'w' => 'water',
	'r' => 'road',
	'h' => 'hill',
	'g' => 'grass'
);

$land_type_keys = array_keys($land_types);
$land_type_count = count($land_type_keys);

$world_array = array();
$world_string = '';

for ($i = 0; $i < $YMAX; ++$i) {
    //$row = '';
	for ($j = 0; $j < $XMAX; ++$j) {
		//fwrite($fp, $land_type_keys[mt_rand(0, $land_type_count - 1)]);
        //$row .= $land_type_keys[mt_rand(0, $land_type_count - 1)];
        $world_string .= $land_type_keys[mt_rand(0, $land_type_count - 1)];
	}
	//fwrite($fp, "\n");
    $world_string .= "\n";
}

//echo $world_string;

fwrite($fp, $world_string);

//print_r($world_array);

