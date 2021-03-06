<?php

require_once 'config.php';

if (isset($_GET['x']) && isset($_GET['y']) && isset($_GET['z'])) {
    $coords = array('coord_x' => $_GET['x'], 'coord_y' => $_GET['y'], 'coord_z' => $_GET['z']);
    
}

$doctype = DOMImplementation::createDocumentType('html', '-//W3C//DTD XHTML 1.0 Strict//EN', 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd');
$doc = DOMImplementation::createDocument(null, 'html', $doctype);
$doc->formatOutput = true;
$doc->encoding = 'utf-8';

$html = $doc->getElementsByTagName('html')->item(0);

$html->appendChild($head = $doc->createElement('head'));

$head->appendChild($doc->createElement('title', 'Venture'));

$head->appendChild($style = $doc->createElement('link'));
$style->setAttribute('rel', 'stylesheet');
$style->setAttribute('type', 'text/css');
$style->setAttribute('href', 'location.css');

$head->appendChild($style2 = $doc->createElement('link'));
$style2->setAttribute('rel', 'stylesheet');
$style2->setAttribute('type', 'text/css');
$style2->setAttribute('href', '../play.css');

$html->appendChild($body = $doc->createElement('body'));

$body->appendChild($location_matrix_container = $doc->createElement('div'));



echo $doc->saveXML();
