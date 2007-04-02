<?php

require_once 'config.php';

$person_table = new PersonTable();

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

if (! isset($_GET['id'])) {
    $title->nodeValue .= ' - People list';
    $body->appendChild($table = $doc->createElement('table'));
    
    $table->appendChild($caption = $doc->createElement('caption', 'People'));

    $table->appendChild($first_row = $doc->createElement('tr'));    
    $table_headers = array('Name', 'Gender', '# Spouses', '# Children');    
    foreach ($table_headers as $table_header) {
        $first_row->appendChild($doc->createElement('th', $table_header));
    }
    foreach ($person_table->fetchAll(null, array('name_last', 'name_first'), VILLAGE_DISPLAY_LIMIT) as $person) {
        $table->appendChild(create_person_row($person));
    }
} else {
    $person = $person_table->fetchRow('`id` = ' . $_GET['id']);
    $title->nodeValue .= ' - ' . $person->__toString();
    $body->appendChild($h1 = $doc->createElement('h1', $person->getFullName()));
    if ($person->isMarried()) {
        $body->appendChild(create_spouse_table($person));
    } else {
        $body->appendChild($p = $doc->createElement('p', 'No spouses'));
    }

    if ($person->hasChildren()) {
        $body->appendChild($table = $doc->createElement('table'));
        $table->appendChild($caption = $doc->createElement('caption', 'Children'));
        $table->appendChild($first_row = $doc->createElement('tr'));
        $first_row->appendChild($th = $doc->createElement('th', 'Name'));
        foreach ($person->getChildren() as $child) {
            $table ->appendChild($tr = $doc->createELement('tr'));
            $tr->appendChild($td = $doc->createElement('td'));
            $td->appendChild($a = $doc->createElement('a'));
            $a->setAttribute('href', '?id=' . $child->id);
            $a->nodeValue = $child->__toString();
        }
    } else {
        $body->appendChild($p = $doc->createElement('p', 'No children'));
    }

    $body->appendChild($p = $doc->createElement('p'));
    $p->appendChild($a = $doc->createElement('a', 'Return to people list'));
    $a->setAttribute('href', 'display-people.php');
}

$total_time = microtime(true) - $start_time;

$body->appendChild($doc->createElement('p', 'Rendered page in ' . $total_time . ' seconds'));

echo $doc->saveXML();
