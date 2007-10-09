<?php

function marriage_form()
{
    global $doc, $people, $person;
    
    $form = $doc->createElement('form');
    
    
    
    return $form;
}

function person_form()
{
    global $doc, $people;
    
    $names = new Names();
    
    $form = $doc->createElement('form');
    
    $form->appendChild($select = $doc->createElement('select'));
    
    foreach ($names->fetchAll("`gender` = 'female'") as $female_name) {
        $select->appendChild($option = $doc->createElement('option', $female_name->value));
        $option->setAttribute('value', $female_name->id);
    }
    
    $select->setAttribute('name', 'name');
    $select->setAttribute('id', 'name');
    
    $form->appendChild($label = $doc->createElement('label', 'name'));
}