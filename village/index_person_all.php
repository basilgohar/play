<?php

$title->nodeValue .= ' - People list';

$body->appendChild($h2 = $doc->createElement('h2'));
$h2->appendChild($a = $doc->createElement('a'));
$a->setAttribute('href', 'index.php?subject=person');
$a->nodeValue = 'People list';

$body->appendChild(create_person_table($people->fetchOrderedRowset()->toArray(), 'People'));
