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
$link->setAttribute('href', 'entity.css');

$html->appendChild($body = $doc->createElement('body'));

/*
switch ($case) {
    case 'add':
        break;
    case 'edit':
        break;
    case 'delete':
        break;
    default:
        break;
}
*/

$total_time = microtime(true) - $start_time;

$body->appendChild($doc->createElement('p', 'Rendered page in ' . $total_time . ' seconds'));

echo $doc->saveXML();
