<?php

require_once 'config.inc.php';

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
