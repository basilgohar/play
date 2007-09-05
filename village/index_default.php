<?php

$subjects = array('person' => 'Person');

$body->appendChild($p = $doc->createElement('p'));
$p->nodeValue = 'Choose a type of subject upon which to act';

$body->appendChild($ul = $doc->createElement('ul'));

foreach ($subjects as $subject_key => $subject_value) {
    $ul->appendChild($li = $doc->createElement('li'));
    $li->appendChild($a = $doc->createElement('a'));
    $a->setAttribute('href', '?subject=' . $subject_key);    
    $a->nodeValue = $subject_value;
}
