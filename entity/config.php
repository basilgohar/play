<?php

require_once '../config.php';

require_once 'lib/EntityTable.php';
require_once 'lib/TypeTable.php';
require_once 'lib/EntityTypeTable.php';
require_once 'lib/EntityTypeEntityTypeTable.php';
require_once 'lib/TypeTypeTable.php';

$tables_sql = array();

$tables_sql['entity'] = "CREATE TABLE IF NOT EXISTS `entity` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`name` VARCHAR(255) NOT NULL,
`value` TEXT NOT NULL,
`active` ENUM('0','1') NOT NULL
)";

$tables_sql['type'] = "CREATE TABLE IF NOT EXISTS `type` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`entity_id` INT UNSIGNED NOT NULL DEFAULT '0',
`active` ENUM('0','1') NOT NULL
)";

$tables_sql['entity_type'] = "CREATE TABLE IF NOT EXISTS `entity_type` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`entity_id` INT UNSIGNED NOT NULL DEFAULT '0',
`type_id` INT UNSIGNED NOT NULL DEFAULT '0',
`active` ENUM('0','1') NOT NULL
)";

$tables_sql['entity_entity'] = "CREATE TABLE IF NOT EXISTS `entity_entity` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
`entity_id_1` INT UNSIGNED NOT NULL DEFAULT '0',
`entity_id_2` INT UNSIGNED NOT NULL DEFAULT '0',
`active` ENUM('0','1') NOT NULL
)";
