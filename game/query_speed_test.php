<?php

set_time_limit( 0 );

include( 'functions.inc.php' );

$insert_query = "INSERT INTO heap ( name, description ) VALUES ( 'name', 'description' )";
$insert_count = 10000;

$conn = mysql_pconnect( 'localhost', 'root', 'regnis' );
mysql_select_db( 'test' );

//  Heap - Normal Insert - Raw


$start_time = getmicrotime();
for( $i = 0; $i < $insert_count; $i++ ) {
	mysql_query( $insert_query );
}

$end_time = getmicrotime();
$total_time = $end_time - $start_time;
debug( "It took $total_time seconds to process $insert_count queries for a HEAP table." );

//  MyISAM - Normal Insert - Raw

$insert_query = "INSERT INTO myisam ( name, description ) VALUES ( 'name', 'description' )";

$start_time = getmicrotime();
for( $i = 0; $i < $insert_count; $i++ ) {
	mysql_query( $insert_query );
}
$end_time = getmicrotime();
$total_time = $end_time - $start_time;
debug( "It took $total_time seconds to process $insert_count queries for a MyISAM table." );

//  Heap - Delayed Insert - Raw

$insert_query = "INSERT DELAYED INTO heap ( name, description ) VALUES ( 'name', 'description' )";

$start_time = getmicrotime();
for( $i = 0; $i < $insert_count; $i++ ) {
	mysql_query( $insert_query );
}
$end_time = getmicrotime();
$total_time = $end_time - $start_time;
debug( "It took $total_time seconds to process $insert_count DELAYED queries for a HEAP table." );

//  MyISAM - Delayed Insert - Raw

$insert_query = "INSERT DELAYED INTO myisam ( name, description ) VALUES ( 'name', 'description' )";

$start_time = getmicrotime();
for( $i = 0; $i < $insert_count; $i++ ) {
	mysql_query( $insert_query );
}
$end_time = getmicrotime();
$total_time = $end_time - $start_time;
debug( "It took $total_time seconds to process $insert_count DELAYED queries for a MyISAM table." );

//  Heap - Normal Insert - Query function

$insert_query = "INSERT INTO heap ( name, description ) VALUES ( 'name', 'description' )";

$start_time = getmicrotime();
for( $i = 0; $i < $insert_count; $i++ ) {
	query( $insert_query );
}
$end_time = getmicrotime();
$total_time = $end_time - $start_time;
debug( "It took $total_time seconds to process $insert_count queries for a HEAP table using the Query function." );

//  MyISAM - Normal Insert - Query function

$insert_query = "INSERT INTO myisam ( name, description ) VALUES ( 'name', 'description' )";

$start_time = getmicrotime();
for( $i = 0; $i < $insert_count; $i++ ) {
	query( $insert_query );
}
$end_time = getmicrotime();
$total_time = $end_time - $start_time;
debug( "It took $total_time seconds to process $insert_count queries for a MyISAM table using the Query function." );

?>