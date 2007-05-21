<?php

require_once( 'functions.inc.php' );
require_once( 'character.inc.php' );

//set_time_limit( 10000 );

header( 'Refresh: 0; URL=http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] );

$char1 = new Character( Character::GetRandomCharacterId() );
$char2 = new Character( Character::GetRandomCharacterId() );

while( $char1->GetAttribute( 'id' ) === $char2->GetAttribute( 'id' ) ) {
	$char2 = new Character( Character::GetRandomCharacterId() );
}

Character::CharacterBattle( $char1, $char2, true );


/*

$characters = array();

$characters[0] = $char1;
$characters[1] = $char2;

$attacker = mt_rand( 0, 1 );
$defender = 1 - $attacker;

$characters[$attacker]->SetAttribute( 'life', 100 );
$characters[$defender]->SetAttribute( 'life', 100 );

debug( $characters );

$loop_counter = 0;
debug( 'And the battle begins!' );
debug( $characters[$attacker]->GetAttribute( 'name' ).' gets the first attack.' );

ob_flush();
flush();

while( $characters[$attacker]->GetAttribute( 'life' ) > 0 && $characters[$defender]->GetAttribute( 'life' ) > 0 ) {
	$loop_counter++;
	if( Character::SuccessfulAttack( $characters[$attacker]->AttackChance(), $characters[$defender]->DefendChance() ) ) {
		$attack_strength = $characters[$attacker]->AttackStrength();
		debug( $characters[$attacker]->GetAttribute( 'name' ).' attacks for '.$attack_strength.' points' );
		ob_flush();
		flush();
		$characters[$defender]->SetAttribute( 'life', $characters[$defender]->GetAttribute( 'life' ) - $attack_strength );
	}
	else {
//		debug( $characters[$defender]->GetAttribute( 'name' ).' successfully defends against '.$characters[$attacker]->GetAttribute( 'name' ).'\'s attack.' );
	}
		
	//  This swaps the attacker with the defender
	
	$defender = 1 - $defender;
	$attacker = 1 - $attacker;
}

query( 'UPDATE characters SET wins = wins + 1 WHERE id = '.$characters[$defender]->GetAttribute( 'id' ) );
query( 'UPDATE characters SET losses = losses + 1 WHERE id = '.$characters[$attacker]->GetAttribute( 'id' ) );

debug( $characters[$defender]->GetAttribute( 'name' ).' is the winner!' );
debug( 'And it only took '.$loop_counter.' loops to do it, too!' );
*/
/*

if( !( $char1 = GetRandomCharacter() ) ) exit();
if( !( $char2 = GetRandomCharacter() ) ) exit();

header( 'Refresh: 0; URL=http://'.$_SERVER['HTTP_HOST'].'/game/character_battle.php' );



while( $char2['id'] == $char1['id'] ) {
	$char2 = GetRandomCharacter();
}

echo 'Character 1';
echo '<br />';
echo 'Name: '.$char1['name']."\n";
echo '<br />';
echo 'Strength: '.$char1['strength']."\n | ";
echo 'Dexterity: '.$char1['dexterity']."\n | ";
echo 'Agility: '.$char1['agility']."\n";
echo '<br />';
echo 'Wins: '.$char1['wins']."\n | ";
echo 'Losses: '.$char1['losses']."\n";

echo '<br /><br />';

echo 'Character 2';
echo '<br />';
echo 'Name: '.$char2['name']."\n";
echo '<br />';
echo 'Strength: '.$char2['strength']."\n | ";
echo 'Dexterity: '.$char2['dexterity']."\n | ";
echo 'Agility: '.$char2['agility']."\n";
echo '<br />';
echo 'Wins: '.$char2['wins']."\n | ";
echo 'Losses: '.$char2['losses']."\n";
CharacterFight( $char1, $char2 );

*/

?>