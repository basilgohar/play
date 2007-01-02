<?php

set_time_limit(0);

define('LOGFILE', 'access_log_audioislam');
define('PATTERN', '/^([0-9a-z.-]+) - (.+) \[(.+)\] "(.*)" ([0-9]+) ([0-9-]+) "(.*)" "(.*)"$/');

require_once '../config.inc.php';

$max_sizes = array();

if (! $fp = fopen(LOGFILE, 'r')) {
	throw new Exception('Could not open file "' . LOGFILE . '"');
}

$count = 0;

while (false !== ($line = fgets($fp))) {
	if (! preg_match(PATTERN, $line, $matches)) {
		echo $line . "\n";
		break;
	} else {
		//print_r($matches);
		$match_index = 0;
		foreach ($matches as $match) {
			$length = strlen($match);
			if ($length > $max_sizes[$match_index]) {
				$max_sizes[$match_index] = $length;
			}
			++$match_index;
		}
	}
	++$count;
}

fclose($fp);

echo 'Max match lengths:' . "\n";

print_r($max_sizes);

echo $count . ' lines processed' . "\n";

