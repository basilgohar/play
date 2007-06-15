<?php

define('VILLAGE_POPULATION', 100000);
define('VILLAGE_DISPLAY_LIMIT', 100);
define('VILLAGE_CONTROLLER_PATH', '/home/basil.gohar/public_html/play/village/controllers');
define('VILLAGE_SPOUSE_MAX_MALE', 4);
define('VILLAGE_SPOUSE_MAX_FEMALE', 1);

$CFG = array();

$CFG['db']['dbname'] = 'play';

require_once '../config.inc.php';

require_once 'lib/tables.php';
require_once 'lib/person.php';
require_once 'lib/marriage.php';
require_once 'lib/display.php';

$tables_sql = array();

//  Ensure all tables SQL have IF NOT EXISTS!
/*
$tables_sql['Names'] = "CREATE TABLE IF NOT EXISTS `Names` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `value` varchar(13) collate utf8_unicode_ci NOT NULL,
  `type` enum('female','last','male') collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$tables_sql['People'] = "CREATE TABLE IF NOT EXISTS `People` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name_first_id` mediumint(5) unsigned NOT NULL,
  `name_last_id` mediumint(5) unsigned NOT NULL,
  `gender` enum('female','male') collate utf8_unicode_ci NOT NULL,
  `date_birth` datetime NOT NULL,
  `date_death` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name_first_id` (`name_first_id`),
  KEY `name_last_id` (`name_last_id`),
  CONSTRAINT `name_first_id_fk` FOREIGN KEY (`name_first_id`) REFERENCES `Names` (`id`),
  CONSTRAINT `name_last_id_fk` FOREIGN KEY (`name_last_id`) REFERENCES `Names` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$tables_sql['Families'] = "CREATE TABLE IF NOT EXISTS `Families` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `person_id` int(10) unsigned NOT NULL,
  `mother_id` int(10) unsigned NOT NULL,
  `father_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `person_id` (`person_id`),
  KEY `mother_id` (`mother_id`),
  KEY `father_id` (`father_id`),
  CONSTRAINT `person_id_fk` FOREIGN KEY (`person_id`) REFERENCES `People` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mother_id_fk` FOREIGN KEY (`mother_id`) REFERENCES `People` (`id`) ON DELETE CASCADE,
  CONSTRAINT `father_id_fk` FOREIGN KEY (`father_id`) REFERENCES `People` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
";

$tables_sql['Marriages'] = "CREATE TABLE IF NOT EXISTS `Marriages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `husband_id` int(10) unsigned NOT NULL,
  `wife_id` int(10) unsigned NOT NULL,
  `date_married` datetime NOT NULL,
  `date_divorced` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `husband_id` (`husband_id`),
  KEY `wife_id` (`wife_id`),
  CONSTRAINT `husband_id_fk` FOREIGN KEY (`husband_id`) REFERENCES `People` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wife_id_fk` FOREIGN KEY (`wife_id`) REFERENCES `People` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
*/
///*
$tables_sql['Names'] = "CREATE TABLE IF NOT EXISTS `Names` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `value` varchar(13) collate utf8_unicode_ci NOT NULL,
  `type` enum('female','last','male') collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$tables_sql['People'] = "CREATE TABLE IF NOT EXISTS `People` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name_first_id` mediumint(5) unsigned NOT NULL,
  `name_last_id` mediumint(5) unsigned NOT NULL,
  `gender` enum('female','male') collate utf8_unicode_ci NOT NULL,
  `date_birth` datetime NOT NULL,
  `date_death` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name_first_id` (`name_first_id`),
  KEY `name_last_id` (`name_last_id`),
  KEY `gender` (`gender`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$tables_sql['Families'] = "CREATE TABLE IF NOT EXISTS `Families` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `person_id` int(10) unsigned NOT NULL,
  `mother_id` int(10) unsigned NOT NULL,
  `father_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `person_id` (`person_id`),
  KEY `mother_id` (`mother_id`),
  KEY `father_id` (`father_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
";

$tables_sql['Marriages'] = "CREATE TABLE IF NOT EXISTS `Marriages` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `husband_id` int(10) unsigned NOT NULL,
  `wife_id` int(10) unsigned NOT NULL,
  `date_married` datetime NOT NULL,
  `date_divorced` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `husband_id` (`husband_id`),
  KEY `wife_id` (`wife_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
//*/
/*
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
    )
);
*/

$join_sql = "SELECT p.id , names_first.value name_first , names_last.value name_last , p.gender , (COUNT(mh.id )+COUNT(mw.id ))spouses
FROM People p
JOIN Names names_first ON names_first.id =p.name_first_id
JOIN Names names_last ON names_last.id =p.name_last_id
LEFT JOIN Marriages mh ON mh.husband_id =p.id
LEFT JOIN Marriages mw ON mw.wife_id =p.id
GROUP BY p.id
ORDER BY `p`.`id` ASC";