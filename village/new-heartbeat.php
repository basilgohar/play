<?php

require_once 'config.php';

$current_date = $db->fetchOne("SELECT `value` FROM `Info` WHERE `key` = 'current_date'");
echo "Date: $current_date\n";

$people_ids = $db->fetchCol("SELECT `id` FROM `People` WHERE `date_death` = '0000-00-00 00:00:00'");

echo '# of people: ' . count($people_ids) . "\n";

//shuffle($people_ids);

$people = new People();

$actions = array('marry', 'birth', 'murder', 'die');

foreach ($people_ids as $person_id) {
    $person = $people->fetchRow("`id` = $person_id");
    
    $action = $actions[mt_rand(0,3)];
    
    switch ($action) {
        case 'marry':
            'male' === $person->gender ? $spouse_gender = 'female' : $spouse_gender = 'male';
            if ($potential_spouse = $people->fetchRandomPersonEligableForMarriage($spouse_gender)) {
                if ($person->marryTo($potential_spouse)) {
                    echo "$person has married $potential_spouse\n";
                }
            }
            break;
        case 'birth':
            if ($child = $person->haveChild()) {
                echo "$person has given birth to $child\n";
            }
            break;
        case 'murder':
            if ($victim = $people->fetchRow('`id` = ' . array_pop($people_ids))) {
                $victim->date_death = $current_date;
                $victim->save();
                echo "$person has killed $victim\n";
            }
            break;
        case 'die':
            $person->date_death = $current_date;
            $person->save();
            echo "$person has died of natural causes\n";
            break;
    }
}

