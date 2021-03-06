<?php

define('LEFTWARDS_ARROW', 8592);
define('RIGHTWARDS_ARROW', 8594);
define('LEFTWARDS_ARROW_TO_BAR', 8676);
define('RIGHTWARDS_ARROW_TO_BAR', 8677);

function create_person_row($person_id)
{
    global $doc;
    global $table_data;

    global $people;
    $person = $people->fetchRow("`id` = $person_id");

    $person_name = "$person->name_first $person->name_last";
    $person_gender = $person->gender;
    $person_spouse_count = count($person->getSpouses());
    $person_child_count = count($person->getChildren());

    $table_data[] = array($person_name, $person_gender, $person_spouse_count, $person_child_count);

    $tr = $doc->createElement('tr');
    $tr->appendChild($td_name = $doc->createElement('td'));
    $td_name->appendChild($a = $doc->createElement('a', $person_name));
    $a->setAttribute('href', 'index.php?subject=person&subject_id=' . $person->id);        
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
    $table->appendChild(create_table_caption($caption));
    $table->appendChild($first_row = $doc->createElement('tr'));
    $table_headers = array('Name', 'Gender', '# Spouses', '# Children');

    foreach ($table_headers as $table_header) {
        $first_row->appendChild($doc->createElement('th', $table_header));
    }

    foreach ($people as $person) {
        $table->appendChild(create_person_row($person['id']));
    }

    return $table;
}

function create_table_caption($text = '', $offset = 0)
{
    global $doc;

    $caption = $doc->createElement('caption');

    $caption->appendChild($beginning = $doc->createElement('a', '&#' . LEFTWARDS_ARROW_TO_BAR . ';'));
    $caption->appendChild($back = $doc->createElement('a', '&#' . LEFTWARDS_ARROW . ';'));    
    $caption->appendChild($a_caption_text = $doc->createElement('a', $text));
    $caption->appendChild($forward = $doc->createElement('a', '&#' . RIGHTWARDS_ARROW . ';'));
    $caption->appendChild($end = $doc->createElement('a', '&#' . RIGHTWARDS_ARROW_TO_BAR . ';'));

    $a_caption_text->setAttribute('href', 'index.php?subject=person');

    return $caption;
}
