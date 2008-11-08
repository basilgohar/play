<?php

require_once( 'functions.inc.php' );
require_once( 'html.inc.php' );

$start_time = getmicrotime();


//debug( query( 'SELECT * FROM ItemsNodes' ) );

$return_array = query( 'SELECT * FROM ItemsNodes' );

function GetAllSuperParents() {
    return query( 'SELECT ParentId FROM ItemsNodes WHERE ParentId NOT IN ( SELECT ChildId FROM ItemsNodes )' );
}

function FindChildrenRecursively( $ParentId = 0 ) {
    
}

debug( FindChildrenRecursively() );
debug( mysql_error() );

$total_time = getmicrotime() - $start_time;
debug( 'This took '.$total_time.' seconds.' );

?>