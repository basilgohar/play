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
    $table_headers = array('Name', 'Gender', 'Eligable', '# Spouses');    
    foreach ($table_headers as $table_header) {
        $first_row->appendChild($doc->createElement('th', $table_header));
    }
    foreach ($person_table->fetchAll(null, array('name_last', 'name_first'), VILLAGE_DISPLAY_DEFAULT) as $person) {
        $table->appendChild($tr = $doc->createElement('tr'));
        $tr->appendChild($td = $doc->createElement('td'));
        $td->appendChild($a = $doc->createElement('a', $person->__toString()));
        $a->setAttribute('href', '?id=' . $person->id);        
        $tr->appendChild($td_gender = $doc->createElement('td', $person->gender));
        $tr->appendChild($doc->createElement('td', $person->isEligableForMarriage() ? 'yes' : 'no'));
        $tr->appendChild($doc->createElement('td', $person->getSpouseCount()));
    }
} else {
    $person = $person_table->fetchRow('`id` = ' . $_GET['id']);
    $title->nodeValue .= ' - ' . $person->__toString();
    $body->appendChild($h1 = $doc->createElement('h1', $person->getFullName()));
    if ($person->isMarried()) {
        $body->appendChild($table = $doc->createElement('table'));        
        $table->appendChild($caption = $doc->createElement('caption', 'Spouses'));
        $table->appendChild($first_row = $doc->createElement('tr'));
        $first_row->appendChild($th = $doc->createElement('th', 'Name'));
        foreach ($person->getSpouses() as $spouse) {
            $table->appendChild($tr = $doc->createElement('tr'));
            $tr->appendChild($td = $doc->createElement('td'));
            $td->appendChild($a = $doc->createElement('a'));
            $a->setAttribute('href', '?id=' . $spouse->id);
            $a->nodeValue = $spouse->__toString();
        }
    } else {
        $body->appendChild($p = $doc->createElement('p', 'No spouses'));
    }

    if ($person->hasChildren()) {
        
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
