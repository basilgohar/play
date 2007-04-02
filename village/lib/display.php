<?php

function create_person_row(Person $person)
{
    global $doc;
    
    $tr = $doc->createElement('tr');
    $tr->appendChild($td = $doc->createElement('td'));
    $td->appendChild($a = $doc->createElement('a', $person->__toString()));
    $a->setAttribute('href', '?id=' . $person->id);        
    $tr->appendChild($td_gender = $doc->createElement('td', $person->gender));
    $tr->appendChild($doc->createElement('td', count($person->getSpouses())));
    $tr->appendChild($doc->createElement('td', count($person->getChildren())));
    
    return $tr;    
}

function create_spouse_table(Person $person)
{
    global $doc;
    
    $table = $doc->createElement('table');        
    $table->appendChild($caption = $doc->createElement('caption', 'Spouses'));
    $table->appendChild($first_row = $doc->createElement('tr'));
    $first_row->appendChild($th = $doc->createElement('th', 'Name'));
    $first_row->appendChild($th = $doc->createElement('th', '# Children'));
    foreach ($person->getSpouses() as $spouse) {
        $table->appendChild(create_spouse_row($spouse));
    }
    
    return $table;
}

function create_spouse_row(Person $spouse)
{
    global $doc;
    
    $tr = $doc->createElement('tr');
    $tr->appendChild($td = $doc->createElement('td'));
    $td->appendChild($a = $doc->createElement('a'));
    $a->setAttribute('href', '?id=' . $spouse->id);
    $a->nodeValue = $spouse->getFullName();
    $tr->appendChild($td = $doc->createElement('td', count($spouse->getChildren())));
    
    return $tr;
}
