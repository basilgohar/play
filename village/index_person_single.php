<?php

$subject_id = $_GET['subject_id'];

$person = $people->fetchRow('`id` = ' . $subject_id);
$title->nodeValue .= ' - ' . $person->__toString();
$body->appendChild($doc->createElement('h1', $person->getFullName()));

if ($person->isMarried()) {
    $body->appendChild(create_person_table($person->getSpouses()->toArray(), 'Spouse(s)'));
} else {
    $body->appendChild($doc->createElement('p', 'No spouses'));
}

if ($person->hasChildren()) {
    $body->appendChild(create_person_table($person->getChildren()->toArray(), 'Children'));
} else {
    $body->appendChild($doc->createElement('p', 'No children'));
}

$body->appendChild($p = $doc->createElement('p'));
$p->appendChild($a = $doc->createElement('a', 'Return to people list'));
$a->setAttribute('href', 'index.php?subject=person');
