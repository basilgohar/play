<?php

function shutdown_function()
{
	global $i;
	echo $i;
}

register_shutdown_function('shutdown_function');

$start_time = microtime(true);

define('COUNT', 1000000000);
