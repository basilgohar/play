<?php

function create_person_row(Person $person)
{
    global $doc;
    global $table_data;
    
    $person_name = $person->getFullName();
    $person_gender = $person->gender;
    $person_spouse_count = count($person->getSpouses());
    $person_child_count = count($person->getChildren());
    
    $table_data[] = array($person_name, $person_gender, $person_spouse_count, $person_child_count);
    
    $tr = $doc->createElement('tr');
    $tr->appendChild($td_name = $doc->createElement('td'));
    $td_name->appendChild($a = $doc->createElement('a', $person_name));
    $a->setAttribute('href', '?id=' . $person->id);        
    $tr->appendChild($td_gender = $doc->createElement('td', $person_gender));
    $tr->appendChild($td_spouse_count = $doc->createElement('td', $person_spouse_count));
    $tr->appendChild($td_children_count = $doc->createElement('td', $person_child_count));

    if ('female' === $person->gender) {
        $tr->setAttribute('class', 'female');
    } else {
        $tr->setAttribute('class', 'male');
    }
    
    return $tr;    
}

function create_person_table(array $people, $caption = 'People')
{
    global $doc;

    $table = $doc->createElement('table');
    //$table->appendChild($caption = $doc->createElement('caption', $caption));
    $table->appendChild(create_table_caption($caption));
    $table->appendChild($first_row = $doc->createElement('tr'));
    $table_headers = array('Name', 'Gender', '# Spouses', '# Children');
    foreach ($table_headers as $table_header) {
        $first_row->appendChild($doc->createElement('th', $table_header));
    }
    foreach ($people as $person) {
        $table->appendChild(create_person_row($person));
    }

    return $table;
}

function create_table_caption($text = '', $limit = 0, $offset = 0)
{
    global $doc;
    
    $caption = $doc->createElement('caption');
    
    $caption->appendChild($a_beginning = $doc->createElement('a', '⇦'));
    $a_beginning->setAttribute('href', '?offset=0');
    $caption->appendChild($a_back = $doc->createElement('a', '←'));
    $a_back->setAttribute('href', '?offset=0');
    $caption->appendChild($a_caption_text = $doc->createElement('a', $text));
    $a_caption_text->setAttribute('href', 'display-people.php');
    $caption->appendChild($a_forward = $doc->createElement('a', '→'));
    $a_forward->setAttribute('href', '?offset=100');
    $caption->appendChild($a_end = $doc->createElement('a', '⇨'));
    $a_end->setAttribute('href', '?offset=100');

    return $caption;    
    
}
