<?php

function location_get_nav()
{
    global $doc;
    
    $main = $doc->createElement('div');
    $main->setAttribute('id', 'location-nav');
    
	$main->appendChild($nw = $doc->createElement('div', 'Northwest'));
	$main->appendChild($n = $doc->createElement('div', 'North'));
	$main->appendChild($ne = $doc->createElement('div', 'Northeast'));
	
	$main->appendChild($w = $doc->createElement('div', 'West'));
	$main->appendChild($c = $doc->createElement('div', 'Center'));
	$main->appendChild($e = $doc->createElement('div', 'East'));
	
	$main->appendChild($sw = $doc->createElement('div', 'Southwest'));
	$main->appendChild($s = $doc->createElement('div', 'South'));
	$main->appendChild($se = $doc->createELement('div', 'Southeast'));
	
	return $main;
}
