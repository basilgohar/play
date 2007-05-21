<?php

set_time_limit( 360 );

require_once( 'army.inc.php' );

$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

header( 'Refresh: 0; URL='.$url );

$start_time = getmicrotime();

//  Reset the active table
/*
$flush_query = "TRUNCATE TABLE active";
query( $flush_query );
*/
$army1 = new Army();
$army2 = new Army();

$squads_per_army = 10;
$characters_per_squad = 1000;

for( $i = 0; $i < $squads_per_army; $i++ ) {
	$squad1 = new Squad();
	$squad2 = new Squad();
	foreach( Character::GetRandomCharacterIds( $characters_per_squad ) as $char_id ) {
		$char = new Character( $char_id );
		$squad1->AddSquadMember( $char );
	}
	foreach( Character::GetRandomCharacterIds( $characters_per_squad ) as $char_id ) {
		$char = new Character( $char_id );
		$squad2->AddSquadMember( $char );
	}
	$army1->AddSquad( $squad1 );
	$army2->AddSquad( $squad2 );
}

debug( 'Army1 has '.$army1->Population().' soldiers.' );
debug( 'Army2 has '.$army2->Population().' soldiers.' );

Army::ArmyBattle( $army1, $army2 );

$elapsed_time = getmicrotime() - $start_time;
debug( 'The war took '.$elapsed_time.' seconds.' );

?>2 );

$elapsed_time = getmicrotime() - $start_time;
debug( 'The war took '.$elapsed_time.' seconds.' );

?>
