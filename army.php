<?php

require_once 'lib/armylib.php';
require_once 'lib/classes/soldier.php';
require_once 'lib/classes/army.php';
require_once 'lib/classes/battlefield.php';

define('ENLISTMENTS', 1000);

$red_army = new Army();
$blue_army = new Army();

$count = 0;

while (++$i < ENLISTMENTS) {
    $red_army->addSoldier(new Soldier());
    $blue_army->addSoldier(new Soldier());
}

while ($soldier = $red_army->getNextSoldier()) {
    echo $soldier->getStat('strength') . "\n";
}