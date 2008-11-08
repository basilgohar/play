<?php

include( 'functions.inc.php' );
$start_time = getmicrotime();

//header( 'Refresh: 0; URL=http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] );

$loops = 4000;

$sql_string = 'INSERT INTO ItemsNodes VALUES ';

for( $i = 0; $i < $loops; ++$i ) {
    $parent_id = mt_rand( 0, 100 );
    $child_id = mt_rand( 0, 100 );
    $sql_string .= "( $parent_id, $child_id ),";
}
query( substr( $sql_string, 0, -1 ) );
$total_time = getmicrotime() - $start_time;

debug( $loops.' queries processed in '.$total_time.' seconds.' );
debug( 'Query processing rate: '.$loops/$total_time.' loops/second.' );
debug( mysql_error() );
?>