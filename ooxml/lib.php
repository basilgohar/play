<?php

function ooxml_list(array $list_items)
{
    global $doc;
    
    $dom_element = $doc->createElement('ul');
    foreach ($list_items as $list_item) {
        $dom_element->appendChild($doc->createElement('li', $list_item));
    }
    
    return $dom_element;
}

function ooxml_list_r(array $list_items)
{
    global $doc;
    
    $dom_element = $doc->createElement('ul');
    foreach ($list_items as $index => $list_item) {
        if (is_array($list_item)) {
            $dom_element->appendChild($li = $doc->createElement('li', $index));
            $li->appendChild(ooxml_list_r($list_item));
        } else {
            $dom_element->appendChild($doc->createElement('li', $list_item));
        }
    }
    
    return $dom_element;
}

class ooxml_div extends DOMElement
{
    public function __construct($content = NULL)
    {
        parent::__construct('div', $content);
    }
}