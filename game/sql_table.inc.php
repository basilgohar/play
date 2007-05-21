<?php

require_once( 'html.inc.php' );
require_once( 'functions.inc.php' );

class SQL_Table {

	private $sql_attributes;
	private $limit;

	public function __construct( $columns, $table ) {
		$this->SetAttribute( 'columns', $columns );
		$this->SetAttribute( 'table', $table );
	}
	
	public function SetAttribute( $name = NULL, $value = NULL ) {
		if( $name ) {
			$this->sql_attributes[$name] = $value;
		}
	}
	
	public function SetLimit( $limit = NULL ) {
		if( is_numeric( $limit ) ) {
			$this->limit = $limit;
		}
	}
	
	public function GetTable() {
		$sql_string = 'SELECT '.$this->sql_attributes['columns'].' FROM '.$this->sql_attributes['table'];
		if( $this->limit > 0 ) $sql_string .= ' LIMIT '.$this->limit;
		debug( 'This is the SQL string: '.$sql_string );		
		$return_array = query( $sql_string );
		if( mysql_error() ) debug( 'MySQL error: '.mysql_error() );
		if( is_array( $return_array ) ) {
			$array_size = sizeof( $return_array );
			$table = new HTML( 'table' );
			$table->SetAttribute( 'border', '1' );
			$header_row = new HTML( 'tr' );
			foreach( $return_array[0] as $name => $value ) {
				$th = new HTML( 'th' );
				$th->SetContent( $name );
				$header_row->AddChild( $th );
			}
			$table->AddChild( $header_row );
			for( $i = 0; $i < $array_size; $i++ ) {
				$row = $return_array[$i];
				$tr = new HTML( 'tr' );
				foreach( $row as $cell ) {
					$td = new HTML( 'td' );
					$td->SetContent( $cell );
					$tr->AddChild( $td );
				}
				$table->AddChild( $tr );
			}
			return $table;
		}
		return false;
	}
}

?>