<?php

$pid = pcntl_fork();

if ($pid == -1) {
     die('could not fork');
} else if ($pid) {
     // we are the parent
} else {
     // we are the child
}

require_once 'config.php';

$current_date = $db->fetchOne("SELECT `value` FROM `Info` WHERE `key` = 'current_date'");
echo "Date: $current_date\n";

$people_ids = $db->fetchCol("SELECT `id` FROM `People` WHERE `date_death` = '0000-00-00 00:00:00'");

$people_ids_count = count($people_ids);

//echo "# of people: $people_ids_count\n";

$people = new People();

$actions = array();
$actions[] = 'marry';
$actions[] = 'birth';
//$actions[] = 'murder';
//$actions[] = 'die';

$actions_count = count($actions);

$action_results = array();

foreach ($actions as $action) {
    $action_results[$action] = 0;
}

$offset = floor($people_ids_count/2);

if ($pid) {
    $people_ids = array_slice($people_ids, $offset);
} else {
    $people_ids = array_slice($people_ids, 0, $offset);
}

$people_ids_count = count($people_ids);

echo "# of people: $people_ids_count\n";

foreach ($people_ids as $person_id) {
    $person = $people->fetchRow("`id` = $person_id");
    
    $action = $actions[mt_rand(0,$actions_count - 1)];
    
    switch ($action) {
        case 'marry':
            'male' === $person->gender ? $spouse_gender = 'female' : $spouse_gender = 'male';
            if ($potential_spouse = $people->fetchRandomPersonEligableForMarriage($spouse_gender)) {
                if ($person->marryTo($potential_spouse)) {
                    ++$action_results[$action];
                    //echo "$person has married $potential_spouse\n";
                }
            }
            break;
        case 'birth':
            if ($child = $person->haveChild()) {
                ++$action_results[$action];
                //echo "$person has given birth to $child\n";
            }
            break;
        case 'murder':
            if ($victim = $people->fetchRow('`id` = ' . array_pop($people_ids))) {
                $victim->date_death = $current_date;
                $victim->save();
                ++$action_results[$action];
                //echo "$person has killed $victim\n";                
            }
            break;
        case 'die':
            $person->date_death = $current_date;
            $person->save();
            ++$action_results[$action];
            //echo "$person has died of natural causes\n";
            break;
    }
}

foreach ($action_results as $action => $results_count) {
    echo "{$action}s: $results_count\n";
}
