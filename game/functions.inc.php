<?php

ini_set( 'display_errors', 1 );
ini_set( 'display_startup_errors', 1 );

function debug( $debug_string ) {
	echo "\n".'<pre>';
	if( is_string( $debug_string ) ) {
		echo $debug_string;
	}
	else {
		print_r( $debug_string );
	}
	echo '</pre>'."\n";
}

function query( $query_string, $database = NULL ) {
	include( 'config.php' );
	if( $database ) $db = $database;
	$success = false;
	$conn = mysql_pconnect( $hostname, $username, $password );
	mysql_select_db( $db );
	$result = mysql_query( $query_string );
//	mysql_close( $conn );
	if( is_resource( $result ) ) {
		$return_array = array();
			while( $row = mysql_fetch_assoc( $result ) ) {
				$return_array[] = $row;
			}
		return $return_array;
	}
	else return $result;
}

function getmicrotime() {
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

function code2utf( $num ) {  //  NOTE: I didn't write this function.  I got it from http://us2.php.net/manual/en/function.utf8-encode.php
	if($num<128)return chr($num);
	if($num<2048)return chr(($num>>6)+192).chr(($num&63)+128);
	if($num<65536)return chr(($num>>12)+224).chr((($num>>6)&63)+128).chr(($num&63)+128);
	if($num<2097152)return chr(($num>>18)+240).chr((($num>>12)&63)+128).chr((($num>>6)&63)+128) .chr(($num&63)+128);
	return '';
}

function ReplaceCharactersWithNicerOnes( $string ) {
	// For characters AaIiUu
	if( $string !== '' ) {
		$mapping = array();
		$mapping[] = array( 'utf' => 'A', 'iso' => 'A' );
		$mapping[] = array( 'utf' => code2utf( 0x101 ), 'iso' => 'a' );
		$mapping[] = array( 'utf' => code2utf( 0x12a ), 'iso' => 'I' );
		$mapping[] = array( 'utf' => code2utf( 0x12b ), 'iso' => 'i' );
		$mapping[] = array( 'utf' => code2utf( 0x16a ), 'iso' => 'U' );
		$mapping[] = array( 'utf' => code2utf( 0x16b ), 'iso' => 'u' );
		$mapping[] = array( 'utf' => code2utf( 0x060 ), 'iso' =>  '' );
		$mapping[] = array( 'utf' => code2utf( 0x027 ), 'iso' =>  '' );
		
/*			
		if( isset( $_GET['mapping'] ) ) {
			debug( $mapping );
		}
*/
		
//		$decoded_string = utf8_decode( $string );
		$decoded_string = $string;
		$return_string = '';
		for( $i = 0; $i < strlen( $decoded_string ); $i++ ) {
			$altered_character = false;
			foreach( $mapping as $element ) {
				if( $decoded_string{$i} == $element['utf'] ) {
					$return_string .= $element['iso'];
					$altered_character = true;
/*
					if( isset( $_GET['mapping'] ) ) {
						debug( $return_string );
						debug( $altered_character );
						debug( $decoded_string{$i} );
					}
*/					
					break;
				}
			}
			if( !$altered_character ) $return_string .= $decoded_string{$i};
			
		}
		return $return_string;
	}
	return false;
}

function GetSurahInfo( $title = 0 ) {
	if( $title ) {
		$return = query( "SELECT * FROM suwar WHERE soorah_number = $title" );
		if( @$return[0]['transliteration'] != '' ) {
			return $return[0];
		}
	}
	return 0;
}

function TrackVisitor( $ip = '' ) {
	if( $ip != '' ) {
		$script_name = $_SERVER['SCRIPT_NAME'];
		$fifteen_minutes = 60*15; // Number of seconds in 15 minutes
		$time = time();
		$fifteen_minutes_ago = $time - $fifteen_minutes;
		@query( "DELETE FROM visitors WHERE `Time` < '$fifteen_minutes_ago'" );
		@query( "INSERT INTO visitors ( `Time`, `IP`, `Page` ) VALUES ( '$time', '$ip', '$script_name' )" );
	}
}

function Leecher( $ip = '' ) {
	if( $ip != '' ) {
		$time = time();
		$one_minute_ago = $time - 60;
		$return = query( "SELECT COUNT(*) FROM visitors WHERE `IP`='$ip' AND `Time` > '$one_minute_ago' AND `Page` = '/download.php'" );
		if( $return[0]['COUNT(*)'] > 10 ) {
			return true;
		}
	}
	return false;
}

function GetOnlineVisitors() {
	return sizeof( query( "SELECT DISTINCT `IP` FROM visitors" ) );
}

function LowMemoryDownload( $filename, $chunksize = 100000, $time_interval = 1000000 ) {
	// Download rate is $chunksize/$time_interval - $time_interval = microseconds
	$handle = fopen( $filename, 'rb' );
	$filesize = filesize( $filename );
	$total_time = $filesize/2000;
	set_time_limit( $total_time );
	while( !feof( $handle ) ) {
		$start_time = getmicrotime();
		$buffer = fread( $handle, $chunksize );
		echo $buffer;
		LogDownload( $chunksize );
		$elapsed_time = getmicrotime() - $start_time;		

		if( $elapsed_time < ($time_interval/1000000) ) {
			usleep( $time_interval - ($elapsed_time*1000000) );
		}

	}
	fclose( $handle );
}

function LogNow() {
	$time = time();
	$ip = $_SERVER['REMOTE_ADDR'];
	@$page = $_SERVER['SCRIPT_NAME'];
	@$query = $_SERVER['QUERY_STRING'];
	@$referer = $_SERVER['HTTP_REFERER'];
	@$agent = $_SERVER['HTTP_USER_AGENT'];
	query( "INSERT DELAYED INTO log ( `time`, `ip`, `page`, `query`, `referer`, `agent` ) VALUES ( '$time', '$ip', '$page', '$query', '$referer', '$agent' )" );
}

function M3UMaker( $title, $URL, $use_icecast = false ) {
	$length = 0;
	$return_string = "#EXTM3U\r\n";
	$return_string .= "#EXTINF:$length,\"$title\"\r\n";
	if( $use_icecast ) {
		$return_string .= "http://hidayahonline.org:8000/$URL\r\n";
	}
	else {
		$return_string .= "$URL\r\n";
	}
	return $return_string;
}

function LogDownload( $downloaded ) {
	$time = time();
	/*
	$time_increment = 10;
	$cutoff = $time - $time_increment;
	query( "DELETE FROM downloads WHERE time < '$cutoff'" );
	*/
	$sql_string = "INSERT INTO downloads ( `time`, `amount` ) VALUES ( '$time', '$downloaded' )";
	query( $sql_string );
}

function GetDownloadRate() {
	$time = time();
	$time_increment = 5;
	$cutoff = $time - $time_increment;
	query( "DELETE FROM downloads WHERE time < '$cutoff'" );	
	$return_array = query( 'SELECT amount FROM downloads' );
	$total = 0;
	foreach( $return_array as $row ) {
		$total += $row['amount'];
	}
	return $total/$time_increment;
}

function LogMediaDownload( $reciter_id, $title, $format_id ) {
	$ip = $_SERVER['REMOTE_ADDR'];
	$time = time();
	$sql_string = "INSERT INTO download_log ( `time`, `ip`, `reciter`, `title`, `format` ) VALUES ( '$time', '$ip', '$reciter_id', '$title', '$format_id' )";
	query( $sql_string );
}

function GetDownloadStats( $number = 10 ) {
	$sql_string = "SELECT * FROM download_log, suwar, authors WHERE download_log.reciter = authors.author_id AND download_log.title = suwar.soorah_number ORDER BY download_log.time DESC LIMIT $number";
	return query( $sql_string );
}

function FormatDownloadStats( $number = 10 ) {
	$return_array = GetDownloadStats( $number );
	$div = new HTML( 'div' );
	$div->SetAttribute( 'class', 'download_statistics' );
	foreach( $return_array as $row ) {
		if( $row['title'] < 10 ) {
			$row['title'] = '00'.$row['title'];
		}
		else if( $row['title'] < 100 ) {
			$row['title'] = '0'.$row['title'];
		}
		$div_row = new HTML( 'div' );
		$a1 = new HTML( 'a' );
		$a2 = new HTML( 'a' );
		// http://hidayahonline.org/download.php?reciter=7&title=002.mp3
		$a1->SetAttribute( 'href', 'download.php?reciter='.$row['author_id'].'&amp;title='.$row['title'].'.mp3' );
		$a1->SetAttribute( 'class', 'statistics_link' );
		$a1->SetContent( $row['transliteration'] );
		$a2->SetAttribute( 'href', '?page=audio&amp;reciter='.$row['author_id'] );
		$a2->SetAttribute( 'class', 'statistics_link' );
		$a2->SetContent( $row['author_name'] );
		$div_row->SetAttribute( 'class', 'statistics_row' );
		$div_row->SetContent( $a1->Display().' by '.$a2->Display() );
		$div->AddChild( $div_row );
	}
	return $div->Display();
}

function LogHeaders() {
	$request = '';
	foreach( apache_request_headers() as $header => $value ) {
		$request .= "$header: $value\n";
	}
	$response = '';
	foreach( apache_response_headers() as $header => $value ) {
		$response .= "$header: $value\n";
	}
	$ip = $_SERVER['REMOTE_ADDR'];
	$time = time();
	$sql_string = "INSERT INTO headers ( `time`, `ip`, `response`, `request` ) VALUES ( '$time', '$ip', '$response', '$request' )";
	query( $sql_string );	
}

function IsBot() {
	$ip = $_SERVER['REMOTE_ADDR'];
	$request = $_SERVER['REQUEST_URI'];
	$referer = $_SERVER['HTTP_REFERER'];
	$time = time();
}

function GetAllOnlineInfo() {
	$sql_string = "SELECT * FROM visitors ORDER BY Time DESC";
	return query( $sql_string );
}

?>