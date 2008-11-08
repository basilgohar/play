<?php

include( 'character.inc.php' );

header( 'Refresh: 0; URL=http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] );

$character = '';

if( mt_rand( 0, 1 ) ) {
    $character = Character::GenerateRandomCharacter( 'male' );
    $character['gender'] = 'male';
}
else {
    $character = Character::GenerateRandomCharacter( 'female' ); 
    $character['gender'] = 'female';
}

debug( $character );

$gender = 1;

if ( $character['gender'] == 'female' ) {
    $gender = 0;
}

$sql_string = "INSERT INTO characters ( `name`, `gender`, `eyes`, `hair`, `strength`, `dexterity`, `agility`, `class` )
                VALUES (
                '{$character['name']}',
                $gender,
                '{$character['eyes']}',
                '{$character['hair']}',
                {$character['strength']},
                {$character['dexterity']},
                {$character['agility']},
                0
                 )";

if( query( $sql_string ) ) {
    debug( 'Character '.$character['name'].' successfully added.' );
}
else {
    debug( 'There was a problem adding character'.$character['name'].'.' );
    debug( $sql_string );
    debug( mysql_error() );
}



?>
