<?php

require_once( 'functions.inc.php' );
require_once( 'html.inc.php' );

$start_time = getmicrotime();

$table = new HTML( 'table' );
$table->SetAttribute( 'border', '1' );
$caption = new HTML( 'caption' );
$caption->SetContent( 'Some random text stuff' );
$table->AddChild( $caption );
$table_headings = new HTML( 'tr' );
$heading_1 = new HTML( 'th' );
$heading_1->SetContent( 'Id' );
$heading_2 = new HTML( 'th' );
$heading_2->SetContent( 'Name' );
$heading_3 = new HTML( 'th' );
$heading_3->SetContent( 'Description' );
$table_headings->AddChild( $heading_1 );
$table_headings->AddChild( $heading_2 );
$table_headings->AddChild( $heading_3 );
$table->AddChild( $table_headings );
foreach( query( 'SELECT * FROM text_test' ) as $row ) {
	$tr = new HTML( 'tr' );
	foreach( $row as $name => $value ) {
		$max_visible_length = 100;
		$td = new HTML( 'td' );
		$td->SetAttribute( 'style', 'vertical-align: top;' );
		$display_string = substr( $value, 0, $max_visible_length );
		if( strlen( $value ) > $max_visible_length ) {
			$display_string .= '. . .';
		}
		$td->SetContent( $display_string );		
		$tr->AddChild( $td );
	}
	$table->AddChild( $tr );
}
echo $table->Display();

$total_time = getmicrotime() - $start_time;
debug( 'Total script processing time: '.$total_time.' seconds.' );

?>