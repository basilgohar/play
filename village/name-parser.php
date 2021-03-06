<?php

$start_time = microtime(true);

require_once 'config.php';
/*
define('FILE_NAME_MALE', 'dist.male.first');
define('FILE_NAME_FEMALE', 'dist.female.first');
define('FILE_NAME_LAST', 'dist.all.last');

$types = array('male' => FILE_NAME_MALE, 'female' => FILE_NAME_FEMALE, 'last' => FILE_NAME_LAST);
*/
//$names_table = new Names();

$db->query('TRUNCATE TABLE `Names`');

/*
$values_array = array();

foreach ($types as $type => $filename) {
    if (!$fp = fopen('data/' . $filename, 'r')) {
        trigger_error('Could not open file ' . $filename, E_USER_WARNING);
        continue;
    }
    
      while (($line = fgets($fp)) !== false) {
        $normalized_line = preg_replace('/ +/', ' ', $line);
        $values = explode(' ', $normalized_line);
        $values_array[$type][] = $values[0];
    }
}

foreach (array_keys($values_array) as $type) {
    sort($values_array[$type]);
}

$sql = '';
$name_values_count = 0;

//print_r($values_array);

$names_array_string_php = '';

$names_array_string_php .= "<?php 
\$names = array(";

foreach ($values_array as $type => $values) {
    $names_array_string_php .= "\n\t'$type' => array('" . implode("','", $values) . "'),";
}

$names_array_string_php = substr($names_array_string_php, 0, -1);
$names_array_string_php .= "\n);\n";

echo $names_array_string_php;

exit;
*/
require_once 'names_array.php';

$sql = '';
$name_values_count = 0;

foreach ($names as $type => $values) {
    foreach ($values as $value) {
        ++$name_values_count;
        if ('' === $sql) {
            $sql = 'INSERT INTO `Names` (`value`,`type`) VALUES ';
        }
        $sql .= "('" . ucfirst(strtolower($value)) . "','$type'),";
        if (strlen($sql) > $max_sql_string_length) {
            $sql = substr($sql, 0, -1);
            $db->query($sql);
            $sql = '';
        }
    }
}

if ('' !== $sql) {
    //  Process the last remaining SQL statement
    $sql = substr($sql, 0, -1);
    $db->query($sql);
    $sql = '';
}

$total_time = microtime(true) - $start_time;

//echo 'Processed ' . $name_values_count . ' name values in ' . $total_time . ' seconds (' . ($name_values_count/$total_time) . ' records/second)' . "\n";
