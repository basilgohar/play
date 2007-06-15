<?php

require_once 'config.php';

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

$body->appendChild($table = $doc->createElement('table'));
$table->appendChild($caption = $doc->createElement('caption', 'People'));
$table->appendChild($header_row = $doc->createElement('tr'));

$header_row->appendChild($doc->createElement('th', 'Name'));
$header_row->appendChild($doc->createElement('th', 'Spouses'));
$header_row->appendChild($doc->createElement('th', 'Children'));

$people = new People();
foreach ($people->fetchAll(null, 'RAND()', 20) as $person) {
    $table->appendChild($tr = $doc->createElement('tr'));
    $tr->appendChild($doc->createElement('td', $person->getFullName()));
    $tr->appendChild($doc->createElement('td', count($person->getSpouses())));
    $tr->appendChild($doc->createElement('td', count($person->getChildren())));
    if ('female' === $person->gender) {
        $tr->setAttribute('class', 'female');
    } else {
        $tr->setAttribute('class', 'male');
    }    
}

$total_time = microtime(true) - $start_time;

$body->appendChild($doc->createElement('p', 'Rendered page in ' . $total_time . ' seconds'));

echo $doc->saveXML();
