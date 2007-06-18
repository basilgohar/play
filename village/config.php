<?php

define('VILLAGE_POPULATION', 10000);
define('VILLAGE_DISPLAY_LIMIT', 1000);
define('VILLAGE_CONTROLLER_PATH', '/home/basil.gohar/public_html/play/village/controllers');
define('VILLAGE_SPOUSE_MAX_MALE', 4);
define('VILLAGE_SPOUSE_MAX_FEMALE', 1);
define('VILLAGE_START_DATE', '1000-01-01');


define('VILLAGE_HEARTBEAT_PEOPLE_COUNT', 40);
//  Possible actions for the heart beat
define('VILLAGE_HEARTBEAT_MARRIAGE', 1);
define('VILLAGE_HEARTBEAT_CHILD_BIRTH', 2);
define('VILLAGE_HEARTBEAT_MURDER', 3);
define('VILLAGE_HEARTBEAT_NATURAL_DEATH', 4);

$CFG = array();

$CFG['db']['dbname'] = 'play';

require_once '../config.inc.php';

require_once 'lib/tables.php';
require_once 'lib/person.php';
require_once 'lib/marriage.php';
require_once 'lib/display.php';

$db_tables = array (
    'Names' => array (
        'columns' => array (
            'id' => 'integer',
            'value' => 'string',
            'type' => array ('female', 'last', 'male')            
        ),
        'keys' => array (
            'id' => 'primary',
            'value' => 'key'
        )    
    ),
    'People' => array (
        'columns' => array (
            'id' => 'integer',
            'name_first_id' => 'integer',
            'name_last_id' => 'integer',
            'gender' => array('female', 'male'),
            'date_birth' => 'datetime',
            'date_death' => 'datetime'
        ),
        'keys' => array (
            'id' => 'primary',
            'name_first_id' => 'key',
            'name_last_id' => 'key',
            'gender' => 'key'
        )    
    ),
    'Marriages' => array (
        'columns' => array (
            'id' => 'integer',
            'husband_id' => 'integer',
            'wife_id' => 'integer',
            'date_married' => 'datetime',
            'date_divorced' => 'datetime'
        ),
        'keys' => array (
            'id' => 'primary',
            'husband_id' => 'key',
            'wife_id' => 'key'
        )
    ),
    'Families' => array (
        'columns' => array (
            'id' => 'integer',
            'person_id' => 'integer',
            'mother_id' => 'integer',
            'father_id' => 'integer'
        ),
        'keys' => array (
            'id' => 'primary',
            'person_id' => 'key',
            'mother_id' => 'key',
            'father_id' => 'key'
        )
    ),
    'Info' => array (
        'columns' => array (
            'id' => 'integer',
            'key' => 'string',
            'value' => 'string'
        ),
        'keys' => array (
            'id' => 'primary',
            'key' => 'key'
        )
    )
);

$join_sql = "SELECT p.id , names_first.value name_first , names_last.value name_last , p.gender , (COUNT(mh.id )+COUNT(mw.id ))spouses
FROM People p
JOIN Names names_first ON names_first.id =p.name_first_id
JOIN Names names_last ON names_last.id =p.name_last_id
LEFT JOIN Marriages mh ON mh.husband_id =p.id
LEFT JOIN Marriages mw ON mw.wife_id =p.id
GROUP BY p.id
ORDER BY `p`.`id` ASC";
