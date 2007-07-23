<?php

require_once 'config.php';

$people = new People();

foreach ($people->fetchAll("`gender` = 'female'") as $potential_mother) {
    if (! $potential_mother->isMarried()) {
        continue;
    }
    
    if (0 === mt_rand(0,2)) {
        $child = $potential_mother->haveChild();
        echo $potential_mother->getFullName() . ' has given birth to ' . $child->getFullName() . "\n";
    }
}
