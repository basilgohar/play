<?php

require_once( 'functions.inc.php' );
require_once( 'text.inc.php' );

header( 'Refresh: 0; URL=http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'] );

$text = new TextGenerator();

//debug( $text->GenerateWord( 2, 200 ) );

$random_paragraph = '';

$name = '';

for( $i = 0; $i < 30; $i++ ) {
    $name = $name.' '.$text->GenerateWord();
}

for( $i = 0; $i < 20000; $i++ ) {
    $random_paragraph = $random_paragraph.' '.$text->GenerateWord();
}

//echo $random_paragraph;

echo $name;

query( "INSERT INTO text_test ( Name, Description )
        VALUES ( '$name', '$random_paragraph' )" );

?>