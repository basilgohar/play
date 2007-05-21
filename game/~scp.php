<?php

include( 'functions.inc.php' );

$sql_string = 'SELECT * FROM ahadeeth';

foreach( query( $sql_string, 'hadeeth' ) as $hadeeth ) {
	$uncompressed_size = strlen( $hadeeth['Matn'] );
	$compressed_size = strlen( $hadeeth['CompressedMatn'] );
	echo '<p>';
	echo '<pre>';
	echo 'Uncompressed:'."\t".$uncompressed_size.' bytes<br />';
	echo 'Compressed:'."\t".$compressed_size.' bytes<br />';
	echo '</pre>';
	echo gzuncompress( $hadeeth['CompressedMatn'] );
	echo '</p>';
	echo "\n";
	echo '<hr />';
/*
	$sql_update_string = 'UPDATE ahadeeth SET CompressedMatn=\''.addslashes( gzcompress( $hadeeth['Matn'] ) ).'\'
							WHERE id='.$hadeeth['id'];
	query( $sql_update_string, 'hadeeth' );
*/
}

?>