<?php

ini_set( 'display_startup_errors', '1' );
ini_set( 'display_errors', '1' );

include( 'functions.inc.php' );

$start_time = getmicrotime();

$random_array = array();
for( $i = 0; $i < 100000; $i++ ) {
    $random_array[] = mt_rand();
}
//sort( $random_array );
//debug( $random_array );

$total_time = getmicrotime() - $start_time;

debug( 'Total time: '.$total_time.' seconds.' );

?>