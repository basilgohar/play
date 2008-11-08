<?php

require_once( 'squad.inc.php' );

class Army {

    private $squads;

    public function __construct() {
        $this->squads = array();    
    }
    
    public function AddSquad( Squad &$squad, $check_if_exists = false ) {
        if( $check_if_exists ) {
            if( $this->SquadInArmy( $squad->GetId() ) ) {
                return false;
            }
        }
        $this->squads[] = $squad;
        return true;
    }
    
    public function RemoveSquad( $squad_id = NULL ) {
        if( is_numeric( $squad_id ) ) {
            for( $i = 0; $i < sizeof( $this->squads ) - 1; $i++ ) {
                if( $this->squads[$i]->GetId() == $squad_id ) {
                    unset( $this->squads[$i] );
                    $this->squads = array_values( $this->squads );
                    break;
                }
            }
        }    
    }
    
    public function SquadInArmy( $squad_id = NULL ) {
        if( is_numeric( $squad_id ) ) {
            for( $i = 0; $i < sizeof( $this->squads ) - 1; $i++ ) {
                if( $this->squads[$i]->GetId() == $squad_id ) {
                    return true;
                }
            }
        }
        return false;
    }
    
    public function GetRandomSquad() {
        return $this->squads[mt_rand( 0, sizeof( $this->squads ) - 1 )];
    }
    
    public function Size() {
        return ( sizeof( $this->squads ) - 1 );
    }
    
    public function Population() {
        $population = 0;
        foreach( $this->squads as $squad ) {
            $population += $squad->Size();
        }
        return $population;
    }
    
    public static function ArmyBattle( Army &$army1, Army &$army2, $debug = false ) {
        $loops = 0;
        while( $army1->Size() > 0 && $army2->Size() > 0 ) {
            $battle_result = Squad::SquadBattle( $army1->GetRandomSquad(), $army2->GetRandomSquad(), $debug );
            if( $army1->SquadInArmy( $battle_result['loser']->GetId() ) ) {
                $army1->RemoveSquad( $battle_result['loser']->GetId() );
                echo 'Army1 loses a squad!<br />';
            }
            else {
                $army2->RemoveSquad( $battle_result['loser']->GetId() );
                echo 'Army2 loses a squad!<br />';
            }
            $loops++;
            ob_flush();
            flush();
        }
        if( $army1->Size() > 0 ) {
            echo "<br />Army 1 is the winner in $loops battles!<br />";
        }
        else {
            echo "<br />Army 2 is the winner in $loops battles!<br />";
        }    
    }
}

?>