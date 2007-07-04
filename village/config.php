<?php

define('VILLAGE_POPULATION', 10);
define('VILLAGE_DISPLAY_LIMIT', 1000);
define('VILLAGE_CONTROLLER_PATH', '/home/basil.gohar/public_html/play/village/controllers');
define('VILLAGE_SPOUSE_MAX_MALE', 4);
define('VILLAGE_SPOUSE_MAX_FEMALE', 1);
define('VILLAGE_START_DATE', date('Y-m-d H:i:s'));

define('VILLAGE_HEARTBEAT_PEOPLE_COUNT', 50);
//  Possible actions for the heart beat
define('VILLAGE_HEARTBEAT_MARRIAGE', 1);
define('VILLAGE_HEARTBEAT_CHILD_BIRTH', 2);
define('VILLAGE_HEARTBEAT_MURDER', 3);
define('VILLAGE_HEARTBEAT_NATURAL_DEATH', 4);

$CFG = array();

$CFG['db']['dbname'] = 'play';

$join_sql = "SELECT p.id , names_first.value name_first , names_last.value name_last , p.gender , (COUNT(mh.id )+COUNT(mw.id ))spouses
FROM People p
JOIN Names names_first ON names_first.id =p.name_first_id
JOIN Names names_last ON names_last.id =p.name_last_id
LEFT JOIN Marriages mh ON mh.husband_id =p.id
LEFT JOIN Marriages mw ON mw.wife_id =p.id
GROUP BY p.id";

$super_join_sql = "SELECT p.id, names_first.value name_first, names_last.value name_last, p.gender, (COUNT(mh.id) + COUNT(mw.id)) spouses, (COUNT(ff.id) + COUNT(fm.id)) children
FROM People p
JOIN Names names_first ON names_first.id = p.name_first_id
JOIN Names names_last ON names_last.id = p.name_last_id
LEFT JOIN Marriages mh ON mh.husband_id = p.id
LEFT JOIN Marriages mw ON mw.wife_id = p.id
LEFT JOIN Families ff ON ff.father_id = p.id
LEFT JOIN Families fm ON fm.mother_id = p.id
GROUP BY p.id
ORDER BY name_last, name_first";

$another_super_join_sql = "SELECT p.id, names_first.value name_first, names_last.value name_last, p.gender, (COUNT(mh.id) + COUNT(mw.id)) spouses, (COUNT(ff.id) + COUNT(fm.id)) children
FROM People p
JOIN (Names names_first, Names names_last) ON (names_first.id = p.name_first_id AND names_last.id = p.name_last_id)
LEFT JOIN (Marriages mh, Families ff) ON (mh.husband_id = p.id AND ff.father_id = p.id)
LEFT JOIN (Marriages mw, Families fm) ON (mw.wife_id = p.id AND fm.mother_id = p.id)
GROUP BY p.id
ORDER BY name_last, name_first";
