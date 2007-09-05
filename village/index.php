<?php

require_once 'config.php';

$doctype = DOMImplementation::createDocumentType('html', '-//W3C//DTD XHTML 1.0 Strict//EN', 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd');

$doc = DOMImplementation::createDocument(null, 'html', $doctype);

$doc->formatOutput = true;
$doc->encoding = 'utf-8';

$html = $doc->documentElement;

$html->appendChild($head = $doc->createElement('head'));

$head->appendChild($title = $doc->createElement('title', 'Village Simulator'));
$head->appendChild($link = $doc->createElement('link'));
$link->setAttribute('rel', 'stylesheet');
$link->setAttribute('type', 'text/css');
$link->setAttribute('href', 'village.css');

$html->appendChild($body = $doc->createElement('body'));

$body->appendChild($h1 = $doc->createElement('h1'));
$h1->appendChild($a = $doc->createElement('a'));
$a->setAttribute('href', 'index.php');
$a->nodeValue = 'Village Simulator';

$total_time = microtime(true) - $start_time;

if (isset($_GET['subject'])) {
    $subject = $_GET['subject'];
} else {
    $subject = '';
}

switch ($subject) {
    default:
        require_once 'index_default.php';
        break;
    case 'person':
        require_once 'index_person.php';
        break;
}

$body->appendChild($doc->createElement('p', 'Rendered page in ' . $total_time . ' seconds'));

echo $doc->saveXML();
