<?php

require_once( 'character.inc.php' );

class Squad {
    
    private $id;
    private $squad_members;
    
    public function __construct() {
        $this->squad_members = array();
        $this->id = mt_rand(0, mt_getrandmax() );
    }
    
    public function __destruct() {
        foreach( $this->squad_members as $character ) {
            Character::DeactivateCharacter( $character->GetAttribute( 'id' ) );
        }
    }
    
    public function AddSquadMember( Character &$char, $check_if_member = false ) {
        if( $check_if_member ) {
            if( $this->IsSquadMember( $char->GetAttribute( 'id' ) ) ) {
                return false;
            }
        }
        $this->squad_members[] = $char;
        Character::ActivateCharacter( $char->GetAttribute( 'id' ), $this->id );
        return true;
    }
    
    public function RemoveSquadMember( $character_id = NULL ) {
        if( is_numeric( $character_id ) ) {
            for( $i = 0; $i <= sizeof( $this->squad_members ) - 1; $i++ ) {
                if( $this->squad_members[$i]->GetAttribute( 'id' ) == $character_id ) {
                    unset( $this->squad_members[$i] );
                    $this->squad_members = array_values( $this->squad_members );
                    Character::DeactivateCharacter( $character_id );
                    break;
                }
            }
        }
    }
    
    public function GetRandomSquadMember() {
        return $this->squad_members[mt_rand( 0, sizeof( $this->squad_members ) - 1 )];
    }
    
    public function GetId() {
        return $this->id;
    }
    
    public function GetMemberIds() {
        $member_ids = array();
        foreach( $this->squad_members as $character ) {
            $member_ids[] = $character->GetAttribute( 'id' );
        }
        return $member_ids;
    }
    
    public function IsSquadMember( $character_id = NULL ) {
        if( is_numeric( $character_id ) ) {
            for( $i = 0; $i <= sizeof( $this->squad_members ) - 1; $i++ ) {
                if( $this->squad_members[$i]->GetAttribute( 'id' ) == $character_id ) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function Size() {
        return sizeof( $this->squad_members );
    }
    
    public static function SquadBattle( Squad &$squad1, Squad &$squad2, $debug = false ) {
        $loops = 0;
        while( $squad1->Size() > 0 && $squad2->Size() > 0 ) {
            $battle_result = Character::CharacterBattle( $squad1->GetRandomSquadMember(), $squad2->GetRandomSquadMember(), $debug );
            if( $squad1->IsSquadMember( $battle_result['loser']->GetAttribute( 'id' ) ) ) {
                $squad1->RemoveSquadMember( $battle_result['loser']->GetAttribute( 'id' ) );
            }
            else {
                $squad2->RemoveSquadMember( $battle_result['loser']->GetAttribute( 'id' ) );
            }
            $loops++;
        }
        $return_array = array();
        if( $squad1->Size() > 0 ) {
            $return_array['winner'] = $squad1;
            $return_array['loser'] = $squad2;
        }
        else {
            $return_array['winner'] = $squad2;
            $return_array['loser'] = $squad1;
         }
         return $return_array;
    }

}

?>