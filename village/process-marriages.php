<?php

$start_time = microtime(true);

set_time_limit(0);

require_once 'config.default.php';

$sql_male = "SELECT p.id, COUNT(m.id) AS spouses FROM `People` p LEFT JOIN `Marriages` m ON m.husband_id = p.id WHERE p.gender = 'male' GROUP BY p.id HAVING spouses < " . VILLAGE_SPOUSE_MAX_MALE;
$eligable_men_array = array();
foreach ($db->query($sql_male)->fetchAll() as $eligable_man_array) {
    $eligable_men_array[$eligable_man_array['id']] = $eligable_man_array['spouses'];
}
$sql_female = "SELECT p.id, COUNT(m.id) AS spouses FROM `People` p LEFT JOIN `Marriages` m ON m.wife_id = p.id WHERE p.gender = 'female' GROUP BY p.id HAVING spouses < " . VILLAGE_SPOUSE_MAX_FEMALE;
$eligable_women_array = array();
foreach ($db->query($sql_female)->fetchAll() as $eligable_woman_array) {
    $eligable_women_array[$eligable_woman_array['id']] = $eligable_woman_array['spouses'];
}

$eligable_men_ids = array_keys($eligable_men_array);
$eligable_women_ids = array_keys($eligable_women_array);

shuffle($eligable_men_ids);
shuffle($eligable_women_ids);

$eligable_men_count = count($eligable_men_array);
$eligable_women_count = count($eligable_women_array);

$db->query('ALTER TABLE `Marriages` DISABLE KEYS');
$sql_string = '';

while (count($eligable_women_ids) > 0) {
    if (count($eligable_men_ids) <= 0) {
        //  No more men left to marry
        break;
    }
    
    $eligable_woman_id = array_pop($eligable_women_ids);    
    $eligable_man_id = array_pop($eligable_men_ids);
    
    $values = array($eligable_man_id, $eligable_woman_id, "'" . date('Y-m-d H:i:s') . "'", "''");
    
    if ('' === $sql_string) {
        $sql_string = "INSERT INTO `Marriages` (`husband_id`,`wife_id`,`date_married`,`date_divorced`) VALUES (" . implode(',', $values) . ')';
    } else {
        $sql_string .= ',(' . implode(',', $values) . ')';
    }
    
    if (strlen($sql_string) > $max_sql_string_length) {
        $db->query($sql_string);
        $sql_string = '';
    }
}

if ('' !== $sql_string) {
    $db->query($sql_string);
    $sql_string = '';
}

$db->query('ALTER TABLE `Marriages` ENABLE KEYS');
