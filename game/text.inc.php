<?php

class TextGenerator {

	public $letters;
	public $numbers;
	public $vowels;
	public $consonents;

	public function __construct() {
		$this->letters = array( 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z' );
		$this->vowels = array( 0,4,8,14,20 );
		$this->consonents = array( 1,2,3,5,6,7,9,10,11,12,13,15,16,17,18,19,21,22,23,24,25 );
		$this->numbers = array( '0','1','2','3','4','5','6','7','8','9' );	
	}
	
	public function __destruct() {
	
	}
	
	public function GenerateLetter( $type = 'random' ) {
		switch( $type ) {
			default: {
				return $this->letters[mt_rand( 0, 25 )];
			}
			case 'vowel': {
				return $this->letters[$this->vowels[mt_rand( 0, sizeof( $this->vowels ) - 1 )]];
			}
			case 'consonent': {
				return $this->letters[$this->consonents[mt_rand( 0, sizeof( $this->consonents ) - 1 )]];
			}
			case 'number': {
				return $this->numbers[mt_rand( 0, 9 )];
			}		
		}
	}
	
	public function GenerateWord( $min_length = 2, $max_length = 8, $type = 'random' ) {
		$length = mt_rand( $min_length, $max_length );
		$word = '';
		for( $i = 0; $i < $length; $i++ ) {
			$word = $word.$this->GenerateLetter( $type );
		}
		return $word;	
	}
	
	public function GenerateVowelyWord( $min_length = 2, $max_length = 10 ) {
		$length = mt_rand( $min_length, $max_length );
		$word = '';
		for( $i = 0; $i < $length; $i++ ) {
			if( $i % 2 ) {
				$word .= $this->GenerateLetter( 'vowel' );
			}
			else {
				$word .= $this->GenerateLetter( 'consonent' );
			}
		}
		return $word;
	
	
	}

}



?>