<?php

set_time_limit(0);

define('LOGFILE', 'access_log');
define('PATTERN', '/^([0-9.]+) - (.+) \[(.+)\] "(.*)" ([0-9]+) ([0-9-]+) "(.*)" "(.*)"$/');

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
	}
	++$count;
}

fclose($fp);

echo $count . ' lines processed' . "\n";

