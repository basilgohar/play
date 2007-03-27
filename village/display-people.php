<?php

require_once 'config.php';

$person_table = new PersonTable();

$doctype = DOMImplementation::createDocumentType('html', '-//W3C//DTD XHTML 1.0 Strict//EN', 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd');

$doc = DOMImplementation::createDocument(null, 'html', $doctype);

$doc->formatOutput = true;
$doc->encoding = 'utf-8';

//$doc->appendChild($html = $doc->createElement('html'));

$html = $doc->getElementsByTagName('html')->item(0);

$html->appendChild($head = $doc->createElement('head'));

$head->appendChild($doc->createElement('title', 'A sample XHTML page generated through PHP DOM'));

$html->appendChild($body = $doc->createElement('body'));

$body->appendChild($table = $doc->createElement('table'));

$table->setAttribute('border', '1');

$table->appendChild($caption = $doc->createElement('caption', 'People'));

$table->appendChild($first_row = $doc->createElement('tr'));

$table_headers = array('ID', 'Name', 'Gender', 'Eligable');

foreach ($table_headers as $table_header) {
    $first_row->appendChild($doc->createElement('th', $table_header));
}

foreach ($person_table->fetchAll(null, 'RAND()', 100) as $person) {
    $table->appendChild($tr = $doc->createElement('tr'));
    $tr->appendChild($doc->createElement('td', $person->id));
    $tr->appendChild($doc->createElement('td', $person->getFullName()));
    $tr->appendChild($doc->createElement('td', $person->gender));
    $tr->appendChild($doc->createElement('td', $person->isEligableForMarriage() ? 'yes' : 'no'));
}

echo $doc->saveXML();
