<?php

require_once 'config.php';

$people = new People();

$doctype = DOMImplementation::createDocumentType('html', '-//W3C//DTD XHTML 1.0 Strict//EN', 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd');

$doc = DOMImplementation::createDocument(null, 'html', $doctype);

$doc->formatOutput = true;
$doc->encoding = 'utf-8';

$html = $doc->getElementsByTagName('html')->item(0);

$html->appendChild($head = $doc->createElement('head'));

$head->appendChild($title = $doc->createElement('title', 'Village Simulator'));
$head->appendChild($link = $doc->createElement('link'));
$link->setAttribute('rel', 'stylesheet');
$link->setAttribute('type', 'text/css');
$link->setAttribute('href', 'village.css');

$html->appendChild($body = $doc->createElement('body'));

$table_data = array();

if (! isset($_GET['id'])) {
    $title->nodeValue .= ' - People list';
    $body->appendChild(create_person_table($people->fetchAll(null, null, VILLAGE_DISPLAY_LIMIT)->toArray(), 'People'));
} else {
    $person = $people->fetchRow('`id` = ' . $_GET['id']);
    $title->nodeValue .= ' - ' . $person->__toString();
    $body->appendChild($doc->createElement('h1', $person->getFullName()));
    if ($person->isMarried()) {
        $body->appendChild(create_person_table($person->getSpouses()->toArray()));
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
    $a->setAttribute('href', 'display-people.php');
}

$total_time = microtime(true) - $start_time;

$body->appendChild($doc->createElement('p', 'Rendered page in ' . $total_time . ' seconds'));

echo $doc->saveXML();
