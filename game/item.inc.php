<?php

require_once( 'functions.inc.php' );

class Item {

	private $attributes;
	
	public function __construct( $Id = NULL ) {
		if( Item::IsItem( $Id ) ) {
			$return_array = query( 'SELECT * FROM Items WHERE Id='.$Id.' LIMIT 1' );
			$this->attributes = $return_array[0];
		}
	
	}
	
	public static function IsItem( $Id ) {
		if( is_numeric( $Id ) ) {
			$sql_string = 'SELECT Id FROM Items WHERE Id='.$Id;
			if( query( $sql_string ) ) return true;
		}
		debug( $Id.' is not a valid item!' );
		return false;
	}
	
	public function SetAttribute( $name = NULL, $value = NULL ) {
		if( $name ) {
			$this->attributes[$name] = $value;
			return true;
		}
		return false;
	}
	
	public function GetAttribute( $name = NULL ) {
		if( $name ) {
			return $this->attributes[$name];
		}
		return false;	
	}
	
	public static function GetChildrenIds( $ParentId = NULL ) {
		if( Item::IsItem( $ParentId ) ) {
			$sql_string = 'SELECT ChildId FROM ItemsNodes WHERE ParentId = '.$ParentId;
			$return_array = query( $sql_string );
			$child_ids = array();
			foreach( $return_array as $row ) {
				$child_ids[] = $row['ChildId'];
			}
			return $child_ids;
		}
		return false;
	}
	
	public static function GetParentIds( $ChildId = NULL ) {
		if( Item::IsItem( $ChildId ) ) {
			$sql_string = 'SELECT ParentId FROM ItemsNodes WHERE ChildId = '.$ChildId;
			$return_array = query( $sql_string );
			$parent_ids = array();
			foreach( $return_array as $row ) {
				$parent_ids[] = $row['ParentId'];
			}
			return $child_ids;
		}
		return false;
	}
	
	public static function Add( $Type = NULL, $Name = NULL, $Description = NULL ) {
		$sql_string = 'INSERT INTO Items
						( `Type`, `Name`, `Description` ) VALUES (
						\''.addslashes( $Type ).'\',
						\''.addslashes( $Name ).'\',
						\''.addslashes( $Description ).'\'
						 )';
		return query( $sql_string );
	}
	
	public static function Edit( $Id = NULL, $Name = NULL, $Description = NULL ) {
		if( Item::IsItem( $Id ) ) {
			$sql_string = "UPDATE Items SET
							Name='$name', Description='$Description'
							WHERE Id=$Id";
			return query( $sql_string );
		}
		return false;
	}
	
	public static function Delete( $Id = NULL ) {
		if( Item::IsItem( $Id ) ) {
			$sql_string = 'DELETE FROM Items WHERE `Id` = '.$Id.' LIMIT 1';
			return query( $sql_string );
		}
		return false;
	}



}



?>