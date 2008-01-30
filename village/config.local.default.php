<?php

define('VILLAGE_POPULATION', 20);
define('VILLAGE_DISPLAY_LIMIT', 1000);
define('VILLAGE_CONTROLLER_PATH', '/home/basil.gohar/public_html/play/village/controllers');
define('VILLAGE_SPOUSE_MAX_MALE', 4);
define('VILLAGE_SPOUSE_MAX_FEMALE', 1);
define('VILLAGE_START_DATE', date('Y-m-d H:i:s'));

define('VILLAGE_HEARTBEAT_PEOPLE_COUNT', 50);
//  Possible actions for the heart beat
define('VILLAGE_HEARTBEAT_MARRIAGE', 1);
define('VILLAGE_HEARTBEAT_CHILD_BIRTH', 2);
define('VILLAGE_HEARTBEAT_MURDER', 3);
define('VILLAGE_HEARTBEAT_NATURAL_DEATH', 4);

define('VILLAGE_CITY_COUNT', 10000);

$CFG = array();

$CFG['db']['dbname'] = 'play';
