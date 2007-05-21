<?php

require_once( 'item.inc.php' );
require_once( 'html.inc.php' );
require_once( 'sql_table.inc.php' );

$form = new HTML( 'form' );
$form->SetAttribute( 'action', $_SERVER['PHP_SELF'] );
$form->SetAttribute( 'method', 'post' );
$type_select = new HTML( 'select' );
$type_select->SetAttribute( 'name', 'Type' );
$types = query( 'SELECT * FROM Items WHERE Type=1' );
foreach( $types as $type ) {
	$option = new HTML( 'option' );
	$option->SetAttribute( 'value', $type['Id'] );
	$option->SetContent( $type['Id'].'. '.$type['Name'] );
	$type_select->AddChild( $option );
}
$form->AddChild( $type_select );
$form->AddBr();
$name_input = new HTML( 'input', true );
$name_input->SetAttribute( 'type', 'text' );
$name_input->SetAttribute( 'name', 'Name' );
$name_input->SetAttribute( 'size', '80' );
$form->AddChild( $name_input );
$form->AddBr();
$description_input = new HTML( 'textarea' );
$description_input->SetAttribute( 'rows', '5' );
$description_input->SetAttribute( 'cols', '80' );
$description_input->SetAttribute( 'name', 'Description' );
$form->AddChild( $description_input );
$form->AddBr();
$submit_button = new HTML( 'input', true );
$submit_button->SetAttribute( 'type', 'submit' );
$submit_button->SetAttribute( 'value', 'Submit' );
$form->AddChild( $submit_button );
echo $form->Display();

debug( $_POST );

if( isset( $_POST['Type'] ) ) {
	debug( Item::Add( $_POST['Type'], $_POST['Name'], $_POST['Description'] ) );
	debug( mysql_error() );
}

$sql_table = new SQL_Table( '*', 'Items' );
echo $sql_table->GetTable()->Display();

?>
