<?php

require_once '../config.inc.php';

require_once 'lib/tables.php';
require_once 'lib/Person.class.php';

$sql = array();
$sql[] = "CREATE TABLE IF NOT EXISTS `person` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name_first_id` INT UNSIGNED NOT NULL ,
`name_last_id` INT UNSIGNED NOT NULL ,
`date_birth` DATETIME NOT NULL ,
`date_death` DATETIME NOT NULL ,
`gender` ENUM( 'female', 'male' ) NOT NULL
) ENGINE = MYISAM ;";

$sql[] = "CREATE TABLE IF NOT EXISTS `ancestry` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`person_id` INT UNSIGNED NOT NULL ,
`mother_id` INT UNSIGNED NOT NULL ,
`father_id` INT UNSIGNED NOT NULL
) ENGINE = MYISAM ;";

$sql[] = "CREATE TABLE IF NOT EXISTS `marriage` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`husband_id` INT UNSIGNED NOT NULL ,
`wife_id` INT UNSIGNED NOT NULL ,
`date_married` DATETIME NOT NULL ,
`date_divorced` DATETIME NOT NULL
) ENGINE = MYISAM ;";

foreach ($sql as $one_query) {
    $db->query($one_query);
}
