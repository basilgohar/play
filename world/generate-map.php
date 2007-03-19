<?php

define('XMAX', 200);
define('YMAX', 100000);
define('MAPFILE', 'map');

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

for ($i = 0; $i < YMAX; ++$i) {
	for ($j = 0; $j < XMAX; ++$j) {
		fwrite($fp, $land_type_keys[mt_rand(0, $land_type_count - 1)]);
	}
	fwrite($fp, "\n");
}

//print_r($world_array);

