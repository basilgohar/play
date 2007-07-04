<?php

require_once 'config.default.php';
require_once 'tables.php';

//  Destroy tables
echo 'Destroying tables...';
require_once 'destroy-tables.php';
echo 'done.' . "\n";

//  Create tables
echo 'Creating tables...';
require_once 'create-tables.php';
echo 'done.' . "\n";

//  Load names
echo 'Loading names...';
require_once 'name-parser.php';
echo 'done.' . "\n";

//  Populate Info table
echo 'Populating Info table...';
$info = new Info();
$info_record = $info->fetchNew();
$info_record->key = 'current_date';
$info_record->value = VILLAGE_START_DATE;
$info_record->save();
echo 'done.' . "\n";

//  Generate object & property types
echo 'Generting object & property types...';
echo 'done.' . "\n";

//  Generate people