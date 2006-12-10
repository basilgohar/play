<?php

require_once 'config.php';

$population = new PersonTable();

$people = $population->fetchAll(NULL, 'RAND()', 1000);
$length = sizeof($people);
$persons = array();

foreach ($people as $person) {
    $persons[$persons->id] = $person;
}



/*

$population = new PersonTable();
$marriage = new MarriageTable();

$persons = $population->fetchAll(NULL, 'RAND()', 10000);
$length = sizeof($persons);

$persons_array = array();
foreach ($persons as $person) {
	$persons_array[] = $person;	
}

$persons = $persons_array;

foreach ($persons as $person) {
	$random = mt_rand(0, sizeof($persons) - 1);
	if (person_can_marry($person, $persons[$random])) {
		//echo $person->nameFirst . ' ' . $person->nameLast . ' can marry ' . $persons[$random]->nameFirst . ' ' . $persons[$random]->nameLast . "\n";
		$couple = $marriage->fetchNew();
		$person->gender == 'male' ? $couple->husbandId = $person->id : $couple->wifeId = $person->id;
		$persons[$random]->gender == 'female' ? $couple->wifeId = $persons[$random]->id : $couple->husbandId = $persons[$random]->id;
		$couple->dateMarried = date('Y-m-d H:i:s');
		$couple->dateDivorced = '';
		$couple->save();
	} else {
		echo $person->nameFirst . ' ' . $person->nameLast . ' CAN NOT marry ' . $persons[$random]->nameFirst . ' ' . $persons[$random]->nameLast . "\n";
	}
}

*/