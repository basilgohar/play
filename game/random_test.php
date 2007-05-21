<?php

include( 'functions.inc.php' );

header( 'Refresh: 0; URL=http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] );

$start_time = getmicrotime();

$times = 20000;

$sql_string = 'INSERT INTO random ( `something`, `something_else`, `last_thing` ) VALUES ';

for( $i = 0; $i < $times; ++$i ) {
	$random1 = mt_rand();
	$random2 = mt_rand();
	$random3 = mt_rand();
	
//	query( "INSERT DELAYED INTO random ( `something`, `something_else`, `last_thing` ) VALUES ( '$random1', '$random2', '$random3' )" );
	$sql_string .= "\n( '$random1', '$random2', '$random3' ),";
}
query( substr( $sql_string, 0, -1 ) );

debug( mysql_error() );

$total_time = getmicrotime() - $start_time;

debug( $times.' queries processed in '.$total_time.' seconds.' );
debug( 'It took '.$total_time/$times.' seconds, on average, to process each query.' );

?>