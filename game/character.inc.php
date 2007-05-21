<?php

include_once( 'functions.inc.php' );

class Character {

	private $attributes;
	
	public function __construct( $character_id = NULL ) {	
		if( is_numeric( $character_id ) ) {
			$sql_string = "SELECT * FROM characters WHERE id = $character_id";
			$return_array = query( $sql_string );
			$this->attributes = $return_array[0];
		}
	}
	
	public function SetAttribute( $name = '', $value = '' ) {
		if( $name ) {
			$this->attributes[$name] = $value;
		}
	}
	
	public function GetAttribute( $name = '' ) {
		if( $name ) {
			return $this->attributes[$name];
		}
	}	
	
	public function AttackStrength( $modifier = 1.0 ) {
		$random = mt_rand( -20, 20 );
		$random += 100;
		$random_factor = (float) $random/100;
		$return_value = $this->attributes['strength'] * $modifier * $random_factor;
		return (int) $return_value;		
	}
	
	public function AttackChance( $modifier = 1.0 ) {
		$random = mt_rand( -20, 20 );
		$random += 100;
		$random_factor = (float) $random/100;
		return ( $this->attributes['dexterity'] * $modifier * $random_factor );
	}
	
	public function DefendChance( $modifier = 1.0 ) {
		$random = mt_rand( -20, 20 );
		$random += 100;
		$random_factor = (float) $random/100;
		return ( $this->attributes['agility'] * $modifier * $random_factor );
	}
	
	public static function SuccessfulAttack( $attack_chance = 1.0, $defend_chance = 1.0 ) {
		$random = mt_rand( 0, 10 );
		if( $random == 10 ) return true;
		else {
			$base_attack_success_ratio = (float) $attack_chance / $defend_chance;		
			return ( $base_attack_success_ratio > 1.0 );
		}
	}

	public static function GetRandomCharacterId( $class = 0 ) {
		$sql_string = "SELECT id FROM characters
						LEFT JOIN active ON
						characters.id = active.character_id
						WHERE active.character_id IS NULL
						AND class=$class";
		$character_ids = query( $sql_string );
		return $character_ids[mt_rand( 0, sizeof( $character_ids ) - 1 )]['id'];
	}
	
	public static function GetRandomCharacterIds( $number_of_characters = 1, $class = 0 ) {
		$sql_string = "SELECT id FROM characters
						LEFT JOIN active ON
						characters.id = active.character_id
						WHERE active.character_id IS NULL
						AND class=$class";
		$character_ids = query( $sql_string );
		$return_array = array();
		for( $i = 0; $i < $number_of_characters; $i++ ) {
			if( sizeof( $character_ids ) < 1 ) break;
			$random_index = mt_rand( 0, sizeof( $character_ids ) - 1 );
			$return_array[] = $character_ids[$random_index]['id'];
			unset( $character_ids[$random_index] );
		}
		return $return_array;
	}
	
	public static function GenerateRandomName( $gender ) {
		$first_names_query = '';
		if( $gender == 'male' ) {
			$first_names_query = 'SELECT name FROM names WHERE female=0 AND lastname=0';
		}	
		else if( $gender ==  'female' ) {
			$first_names_query = 'SELECT name FROM names WHERE female=1 AND lastname=0';
		}
		$first_names = query( $first_names_query );		
		$last_names = query( 'SELECT name FROM names WHERE lastname=1' );
		$random_first_name = mt_rand( 0, sizeof( $first_names ) - 1 );
		$random_last_name = mt_rand( 0, sizeof( $last_names ) - 1 );
		return $first_names[$random_first_name]['name'].' '.$last_names[$random_last_name]['name'];
	}
	
	public static function GenerateRandomCharacter( $gender ) {
		$eye_colors = array();
		$hair_colors = array();
		
		$eye_colors[] = 'brown';
		$eye_colors[] = 'blue';
		$eye_colors[] = 'green';
		$eye_colors[] = 'hazel';
		$eye_colors[] = 'grey';
		
		$hair_colors[] = 'brown';
		$hair_colors[] = 'black';
		$hair_colors[] = 'blonde';
		$hair_colors[] = 'red';
		$hair_colors[] = 'white';
		
		$eye_color = $eye_colors[mt_rand( 0, sizeof( $eye_colors ) - 1 )];
		$hair_color = $hair_colors[mt_rand( 0, sizeof( $hair_colors ) - 1)];
		
		$character = array();
		
		$character['name'] = self::GenerateRandomName( $gender );
		$character['eyes'] = $eye_color;
		$character['hair'] = $hair_color;
		$character['strength'] = mt_rand( 20, 80 );
		$character['dexterity'] = mt_rand( 20, 80 );
		$character['agility'] = mt_rand( 20, 80 );
		
		
		return $character;	
	}
	
	public static function GenerateRandomSuperCharacter( $gender ) {
		$eye_colors = array();
		$hair_colors = array();
		
		$eye_colors[] = 'red';
		$eye_colors[] = 'yellow';
		$eye_colors[] = 'purple';
		$eye_colors[] = 'black';
		
		$hair_colors[] = 'brown';
		$hair_colors[] = 'black';
		$hair_colors[] = 'blonde';
		$hair_colors[] = 'red';
		$hair_colors[] = 'white';
		
		$eye_color = $eye_colors[mt_rand( 0, sizeof( $eye_colors ) - 1 )];
		$hair_color = $hair_colors[mt_rand( 0, sizeof( $hair_colors ) - 1)];
		
		$character = array();
		
		$character['name'] = GenerateRandomName( $gender );
		$character['eyes'] = $eye_color;
		$character['hair'] = $hair_color;
		$character['strength'] = mt_rand( 100, 500 );
		$character['dexterity'] = mt_rand( 100, 500 );
		$character['agility'] = mt_rand( 100, 500 );
			
		return $character;
	}
	
	public static function CharacterBattle( &$char1, &$char2, $debug = false ) {
		
		$return_array = array();
	
		$characters = array();
		
		$characters[0] = $char1;
		$characters[1] = $char2;
		
		$attacker = mt_rand( 0, 1 );
		$defender = 1 - $attacker;
		
		$loop_counter = 0;
		
		if( $debug ) debug( $characters );
		
		while( $characters[$attacker]->GetAttribute( 'life' ) > 0 && $characters[$defender]->GetAttribute( 'life' ) > 0 ) {
			$loop_counter++;
			if( Character::SuccessfulAttack( $characters[$attacker]->AttackChance(), $characters[$defender]->DefendChance() ) ) {
				$attack_strength = $characters[$attacker]->AttackStrength();
				if( $debug ) debug( $characters[$attacker]->GetAttribute( 'name' ).' successfully attacks '.$characters[$defender]->GetAttribute( 'name' ).' for '.$attack_strength.' points.' );
				$characters[$defender]->SetAttribute( 'life', $characters[$defender]->GetAttribute( 'life' ) - $attack_strength );
			}				
			//  This swaps the attacker with the defender
			
			$defender = 1 - $defender;
			$attacker = 1 - $attacker;
		}
		
		$return_array['winner'] = $characters[$defender];
		$return_array['loser'] = $characters[$attacker];
		
		$upgrade = self::RandomUpgrade();
		
		if( $debug) {
			debug( $characters[$defender]->GetAttribute( 'name' ).' earned the following upgrades for winning!' );
			debug( $upgrade );		
		}
		
		query( "UPDATE characters SET wins = wins + 1,
				strength = strength + {$upgrade['strength']},
				agility = agility + {$upgrade['agility']},
				dexterity = dexterity + {$upgrade['dexterity']},
				life = life + {$upgrade['life']}				
				WHERE id = ".$characters[$defender]->GetAttribute( 'id' ) );
		query( 'UPDATE characters SET losses = losses + 1 WHERE id = '.$characters[$attacker]->GetAttribute( 'id' ) );
		
		return $return_array;
	}
	
	public static function RandomUpgrade() {
		$attributes = array( 'strength', 'agility', 'dexterity', 'life' );
		$upgrade = array();
		$upgrade['strength'] = 0;
		$upgrade['agility'] = 0;
		$upgrade['dexterity'] = 0;
		$upgrade['life'] = 0;
		$upgrade[$attributes[mt_rand( 0, sizeof( $attributes ) - 1)]] = 1;		
		return $upgrade;
	}
	
	public static function ActivateCharacter( $character_id = 0, $squad_id = 0, $army_id = 0 ) {
		$sql_string = "INSERT INTO active ( `character_id`, `squad_id`, `army_id` )
						VALUES ( $character_id, $squad_id, $army_id )";
		query( $sql_string );
	}
	
	public static function DeactivateCharacter( $character_id = 0 ) {
		$sql_string = "DELETE FROM active WHERE character_id=$character_id";
		query( $sql_string );
	}
	
}

?>
