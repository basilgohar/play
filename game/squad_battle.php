<?php

require_once( 'squad.inc.php' );

header( 'Refresh: 0; URL=http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] );

$squad1 = new Squad();
$squad2 = new Squad();

for( $i = 0; $i < 20; $i++ ) {
    $char1 = new Character( Character::GetRandomCharacterId() );
    $squad1->AddSquadMember( $char1 );
    $char2 = new Character( Character::GetRandomCharacterId() );
    $squad2->AddSquadMember( $char2 );    
}
/*
debug( $squad1 );
debug( $squad2 );
*/

Squad::SquadBattle( $squad1, $squad2, false );

?>