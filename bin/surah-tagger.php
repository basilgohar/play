#!/usr/bin/php
<?php

define('SUWAR_CSV_FILE', '/home/basilgohar/Documents/suwar.csv');

if (! file_exists(SUWAR_CSV_FILE)) {
    throw new Exception('No suwar file found');
}

if (! $fp = fopen(SUWAR_CSV_FILE, 'r')) {
    throw new Exception('Could not open suwar file');
}

while ($csv = fgetcsv($fp)) {
    print_r($csv);
}
