<?php

require_once 'config.php';

$name_ids = array_values($db->fetchCol("SELECT `id` FROM `Names`"));

$prefixes = array(
    'New ',
    'Old ',
    'North ',
    'South ',
    'East ',
    'West '
);

$suffixes = array(
    'shire',
    'ton',
    'town',
    'ford',
    'ville',
    ' City',
    ' Valley',
    ' Heights'
);

$village_city_count = VILLAGE_CITY_COUNT;

for ($i = 0; $i < $village_city_count; ++$i) {
    $city_name = '';
    if (0 === mt_rand(0,10)) {
        $city_name .= $prefixes[mt_rand(0, count($prefixes) - 1)];
    }

    $name_id = $name_ids[mt_rand(0, count($name_ids) - 1)];

    $city_name .= $db->fetchOne("SELECT `value`  FROM `Names` WHERE `id` = $name_id");

    if (0 === mt_rand(0,10)) {
        $city_name .= $suffixes[mt_rand(0, count($suffixes) - 1)];
    }

    $db->query("INSERT INTO `Villages` (`name`) VALUES ('$city_name')");
}
