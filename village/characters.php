<?php
/*
 * Created on Apr 3, 2007
 * 
 * @author Basil Mohamed Gohar <basil@eschoolconsultants.com>
 */

require_once 'config.php';

define('EXTENT', 5000);

$doctype = DOMImplementation::createDocumentType('html', '-//W3C//DTD XHTML 1.0 Strict//EN', 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd');

$doc = DOMImplementation::createDocument(null, 'html', $doctype);

$doc->formatOutput = true;
$doc->encoding = 'utf-8';

$html = $doc->getElementsByTagName('html')->item(0);

$html->appendChild($head = $doc->createElement('head'));

$head->appendChild($title = $doc->createElement('title', 'Characters'));
$head->appendChild($link = $doc->createElement('link'));
$link->setAttribute('rel', 'stylesheet');
$link->setAttribute('type', 'text/css');
$link->setAttribute('href', 'village.css');

$html->appendChild($body = $doc->createElement('body'));

$body->appendChild($table = $doc->createElement('table'));

$table->setAttribute('style', 'font-size: x-large; margin: auto; text-align: center');

$table->appendChild($header_row = $doc->createElement('tr'));
$header_row->appendChild($doc->createElement('th', '#'));
$header_row->appendChild($doc->createElement('th', 'Character'));


for ($i = 0; $i < EXTENT; $i++) {
    $table->appendChild($tr = $doc->createElement('tr'));
    $tr->appendChild($td = $doc->createElement('td', $i));
    $tr->appendChild($td = $doc->createElement('td', '&#' . $i . ';'));
}

echo $doc->saveXML();