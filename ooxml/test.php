<?php

require_once 'lib.php';

$doctype = DOMImplementation::createDocumentType('html', '-//W3C//DTD XHTML 1.0 Strict//EN', 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd');

//$doc = new DOMDocument();

$doc = DOMImplementation::createDocument(null, 'html', $doctype);

$doc->formatOutput = true;
$doc->encoding = 'utf-8';

//$doc->appendChild($html = $doc->createElement('html'));

$html = $doc->getElementsByTagName('html')->item(0);

$html->appendChild($head = $doc->createElement('head'));

$head->appendChild($doc->createElement('title', 'A sample XHTML page generated through PHP DOM'));

$html->appendChild($body = $doc->createElement('body'));

$body->appendChild($doc->createElement('p', 'This is a sample paragraph.'));
$body->appendChild($ul1 = $doc->createElement('ul'));

$list_items = array('apple', 'banana', 'orange', 'cherry', 'tomato', 'grape', 'grapefruit');

for ($i = 0; $i < 10; $i++) {
    $ul1->appendChild($li = $doc->createElement('li', mt_rand()));
    shuffle($list_items);
    $li->appendChild(ooxml_list($list_items));
}

$list_items_r = array(
    array('one', 'two', 'three'),
    array(
        array('apple', 'orange', 'strawberry', 'banana'),
        array(
            'lettuce' => array ('green', 'leafy'),
            'green pepper' => array('green', 'hard'),
            'asparagus')
    ),
    array('red', 'green', 'blue')    
);

$body->appendChild(ooxml_list($list_items));

$body->appendChild($block = new ooxml_div);

$block->appendChild(ooxml_list($list_items));

$body->appendChild($block2 = new ooxml_div('something'));

$block2->appendChild(ooxml_list_r($list_items_r));

echo $doc->saveXML();
