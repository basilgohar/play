<?php

ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );

require_once( 'sql_table.inc.php' );

$start_time = getmicrotime();

$memcache = new Memcache();
if( $memcache->connect( 'localhost', 11211 ) ) {
    debug( 'Connected to memcache successfully!' );
}
else debug( 'Could not connect to memcache.' );

if( $sql_table_display = $memcache->get( 'sql_table_display' ) ) {
    debug( 'We got a cache hit!' );
    echo $sql_table_display;
}
else {
    debug( 'Whoops!  We missed the cache this time...' );
    $sql_table = new SQL_Table( '*', 'text_test' );
//    $sql_table->SetLimit( 10 );
    $display = $sql_table->GetTable()->Display();
    $memcache->set( 'sql_table_display', $display, 0, 60 );
    echo $display;
}

$total_time = getmicrotime() - $start_time;
debug( 'Script processed in '.$total_time.' seconds.' );

debug( $memcache->getStats() );

?>