<?php

require_once 'config.php';

$celltypes = array (
    array( 'name' => 'grass', 'description' => 'Green, luss grassland' ),
    array( 'name' => 'desert', 'description' => 'Barren, dry desert' ),
    array( 'name' => 'water', 'description' => 'Wet, soaking water' ),
    array( 'name' => 'road', 'description' => 'Smooth, flat road' )
);

foreach ($celltypes as $celltype) {
    $sql = "INSERT INTO `Celltype` (`name`,`description`) VALUES ('" . $celltype['name'] . "','" . $celltype['description'] . "')";
    $db->query($sql);
}

for ($i = 0; $i < 255; $i++) {
	$sql = "INSERT INTO `Integer` (`i`) VALUES ($i)";
	$db->query($sql);
}

for ($i = ord('a'); $i <= ord('z'); $i++) {
	$sql = "INSERT INTO `Letter` (`l`) VALUES ('" . chr($i) . "')";
	$db->query($sql);
}
