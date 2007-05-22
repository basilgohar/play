<?php

require_once 'config.php';

$tables_sql = array();

//  Ensure all tables SQL have IF NOT EXISTS!

$tables_sql['name'] = "CREATE TABLE IF NOT EXISTS `name` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `value` varchar(13) collate utf8_unicode_ci NOT NULL,
  `type` enum('female','last','male') collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$tables_sql['person'] = "CREATE TABLE IF NOT EXISTS `person` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name_first_id` mediumint(5) unsigned NOT NULL,
  `name_last_id` mediumint(5) unsigned NOT NULL,
  `gender` enum('female','male') collate utf8_unicode_ci NOT NULL,
  `date_birth` datetime NOT NULL,
  `date_death` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name_first_id` (`name_first_id`),
  KEY `name_last_id` (`name_last_id`),
  CONSTRAINT `name_first_id_fk` FOREIGN KEY (`name_first_id`) REFERENCES `name` (`id`),
  CONSTRAINT `name_last_id_fk` FOREIGN KEY (`name_last_id`) REFERENCES `name` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$tables_sql['family'] = "CREATE TABLE IF NOT EXISTS `family` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `person_id` int(10) unsigned NOT NULL,
  `mother_id` int(10) unsigned NOT NULL,
  `father_id` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `person_id` (`person_id`),
  KEY `mother_id` (`mother_id`),
  KEY `father_id` (`father_id`),
  CONSTRAINT `person_id_fk` FOREIGN KEY (`person_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mother_id_fk` FOREIGN KEY (`mother_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  CONSTRAINT `father_id_fk` FOREIGN KEY (`father_id`) REFERENCES `person` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci
";

$tables_sql['marriage'] = "CREATE TABLE IF NOT EXISTS `marriage` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `husband_id` int(10) unsigned NOT NULL,
  `wife_id` int(10) unsigned NOT NULL,
  `date_married` datetime NOT NULL,
  `date_divorced` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `husband_id` (`husband_id`),
  KEY `wife_id` (`wife_id`),
  CONSTRAINT `husband_id_fk` FOREIGN KEY (`husband_id`) REFERENCES `person` (`id`) ON DELETE CASCADE,
  CONSTRAINT `wife_id_fk` FOREIGN KEY (`wife_id`) REFERENCES `person` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

/*
$tables_sql['name'] = "CREATE TABLE IF NOT EXISTS `name` (
  `id` mediumint(5) unsigned NOT NULL auto_increment,
  `value` varchar(13) collate utf8_unicode_ci NOT NULL,
  `type` enum('female','last','male') collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$tables_sql['person'] = "CREATE TABLE IF NOT EXISTS `person` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name_first_id` mediumint(5) unsigned NOT NULL,
  `name_last_id` mediumint(5) unsigned NOT NULL,
  `gender` enum('female','male') collate utf8_unicode_ci NOT NULL,
  `date_birth` datetime NOT NULL,
  `date_death` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `name_first_id` (`name_first_id`),
  KEY `name_last_id` (`name_last_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";

$tables_sql['family'] = "CREATE TABLE IF NOT EXISTS `family` (
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

$tables_sql['marriage'] = "CREATE TABLE IF NOT EXISTS `marriage` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `husband_id` int(10) unsigned NOT NULL,
  `wife_id` int(10) unsigned NOT NULL,
  `date_married` datetime NOT NULL,
  `date_divorced` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `husband_id` (`husband_id`),
  KEY `wife_id` (`wife_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci";
*/

foreach ($tables_sql as $one_query) {
    $db->query($one_query);
}
