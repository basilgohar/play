<?php

require_once 'config.php';

$person_table = new PersonTable();

foreach ($person_table->fetchAll("`gender` = 'female'") as $potential_mother) {
    if (! $potential_mother->isMarried()) {
        continue;
    }
    
    if (0 === mt_rand(0,9)) {
        $child = $potential_mother->haveChild();
        echo $potential_mother->getFullName() . ' has given birth to ' . $child->getFullName() . "\n";
    }
}
