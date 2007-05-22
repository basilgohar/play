<?php

require_once 'config.php';

$tables_sql = array();

$tables_sql['entity'] = "CREATE TABLE IF NOT EXISTS `entity` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`value` TEXT NOT NULL ,
`active` ENUM( '0', '1' ) NOT NULL
) ENGINE = innodb";

$tables_sql['type'] = "CREATE TABLE IF NOT EXISTS `type` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`value` TEXT NOT NULL ,
`active` ENUM( '0', '1' ) NOT NULL
) ENGINE = innodb";

$tables_sql['entity_type'] = "CREATE TABLE IF NOT EXISTS `entity_type` (
`id` INT UNSIGNED NOT NULL ,
`entity_id` INT UNSIGNED NOT NULL ,
`type_id` INT UNSIGNED NOT NULL ,
`active` ENUM( '0', '1' ) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = innodb";

$tables_sql['entity_type_entity_type'] = "CREATE TABLE IF NOT EXISTS `entity_type_entity_type` (
`id` INT UNSIGNED NOT NULL ,
`entity_type_id_1` INT UNSIGNED NOT NULL ,
`entity_type_id_2` INT UNSIGNED NOT NULL ,
`active` ENUM( '0', '1' ) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = innodb";

$tables_sql['type_type'] = "CREATE TABLE IF NOT EXISTS `type_type` (
`id` INT UNSIGNED NOT NULL ,
`type_id_1` INT UNSIGNED NOT NULL ,
`type_id_2` INT UNSIGNED NOT NULL ,
`active` ENUM( '0', '1' ) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = innodb";

foreach ($tables_sql as $one_query) {
    $db->query($one_query);
}
