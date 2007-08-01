<?php

require_once 'config.php';

$current_date = $db->fetchOne("SELECT `value` FROM `Info` WHERE `key` = 'current_date'");

$doctype = DOMImplementation::createDocumentType('html', '-//W3C//DTD XHTML 1.0 Strict//EN', 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd');

$doc = DOMImplementation::createDocument(null, 'html', $doctype);

$doc->formatOutput = true;
$doc->encoding = 'utf-8';

$html = $doc->documentElement;

$html->appendChild($head = $doc->createElement('head'));

$head->appendChild($title = $doc->createElement('title', 'Village Simulator Heartbeat'));

$head->appendChild($link = $doc->createElement('link'));
$link->setAttribute('rel', 'stylesheet');
$link->setAttribute('type', 'text/css');
$link->setAttribute('href', 'village.css');

$head->appendChild($meta = $doc->createElement('meta'));
$meta->setAttribute('http-equiv', 'refresh');
$meta->setAttribute('content', '0');

$html->appendChild($body = $doc->createElement('body'));

//  Fetch a random sampling of living people
$people_ids = $db->fetchCol("SELECT `id` FROM `People` WHERE `date_death` = '0000-00-00 00:00:00'");
shuffle($people_ids);
$random_people_ids = array_slice($people_ids, 0, VILLAGE_HEARTBEAT_PEOPLE_COUNT);
unset($people_ids);
$random_people_data = $db->fetchAll("SELECT * FROM `People` WHERE `id` IN (" . implode(',', $random_people_ids) . ")");
$people = new People();
while (count($random_people_data) > 0) {
	$person = new Person(array('data' => array_pop($random_people_data), 'table' => $people, 'stored' =>  true));
	switch (mt_rand(1, 4)) {
	    case VILLAGE_HEARTBEAT_MARRIAGE:
	        'male' === $person->gender ? $spouse_gender = 'female' : $spouse_gender = 'male';
	        if ($potential_spouse = $people->fetchRandomPersonEligableForMarriage($spouse_gender)) {
		        if ($person->marryTo($potential_spouse)) {
		            ///*
		            $body->appendChild($p = $doc->createElement('p', $person . ' has married ' . $potential_spouse));
		            $p->setAttribute('class','marriage');
					//*/
		        }
	        }
	        break;
	    case VILLAGE_HEARTBEAT_CHILD_BIRTH:
	        if ($child = $person->haveChild()) {
	            ///*
	            $body->appendChild($p = $doc->createElement('p', $person . ' has given birth to ' . $child));
	            $p->setAttribute('class','birth');
	            //*/
	        }
	        break;
	        /*
	    case VILLAGE_HEARTBEAT_MURDER:
	        if (count($random_people_data) > 0) {	            
	            $victim = new Person(array('data' => array_pop($random_people_data), 'table' => $people, 'stored' => true));
	            $victim->date_death = $current_date;
	            $victim->save();

	            $body->appendChild($p = $doc->createElement('p', $person . ' has MURDERED ' . $victim));
	            $p->setAttribute('class','murder');

	        }
	        break;
	    case VILLAGE_HEARTBEAT_NATURAL_DEATH:
	        $person->date_death = $current_date;
	        $person->save();
	        
	        $body->appendChild($p = $doc->createElement('p', $person . ' has died of natural causes'));
	        $p->setAttribute('class','death');
	        
	        break;
	        */
	}
}

$db->update('Info', array('value' => date('Y-m-d H:i:s', (strtotime($current_date) + 86400))), "`key` = 'current_date'");

$total_time = microtime(true) - $start_time;

$body->appendChild($doc->createElement('p', 'Rendered page in ' . $total_time . ' seconds'));

echo $doc->saveXML();
