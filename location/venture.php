<?php

require_once 'config.inc.php';

$doctype = DOMImplementation::createDocumentType('html', '-//W3C//DTD XHTML 1.0 Strict//EN', 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd');
$doc = DOMImplementation::createDocument(null, 'html', $doctype);
$doc->formatOutput = true;
$doc->encoding = 'utf-8';

$html = $doc->getElementsByTagName('html')->item(0);

$html->appendChild($head = $doc->createElement('head'));

$head->appendChild($doc->createElement('title', 'A sample XHTML page generated through PHP DOM'));

$html->appendChild($body = $doc->createElement('body'));

$body->appendChild(location_get_nav());

echo $doc->saveXML();
