<?php

define('VILLAGE_POPULATION', 10000);
define('VILLAGE_DISPLAY_LIMIT', 100);
define('VILLAGE_CONTROLLER_PATH', '/home/basil.gohar/public_html/play/village/controllers');
define('VILLAGE_SPOUSE_MAX_MALE', 4);
define('VILLAGE_SPOUSE_MAX_FEMALE', 1);

$CFG = array();

$CFG['db']['dbname'] = 'village';

require_once '../config.inc.php';

require_once 'lib/tables.php';
require_once 'lib/person.php';
require_once 'lib/marriage.php';
require_once 'lib/display.php';
