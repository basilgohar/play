<?php

function location_get_nav()
{
    global $doc;
    
    $main = $doc->createElement('div');
    $main->setAttribute('id', 'location-nav');
    
	$main->appendChild($nw = $doc->createElement('div', 'Northwest'));
    $nw->setAttribute('class', 'nav north west');
	$main->appendChild($n = $doc->createElement('div', 'North'));
    $n->setAttribute('class', 'nav north');
	$main->appendChild($ne = $doc->createElement('div', 'Northeast'));
    $ne->setAttribute('class', 'nav north east');
	
	$main->appendChild($w = $doc->createElement('div', 'West'));
    $w->setAttribute('class', 'nav west');
	$main->appendChild($c = $doc->createElement('div', 'Center'));
    $c->setAttribute('class', 'nav center');
	$main->appendChild($e = $doc->createElement('div', 'East'));
    $e->setAttribute('class', 'nav east');
	
	$main->appendChild($sw = $doc->createElement('div', 'Southwest'));
    $sw->setAttribute('class', 'nav south west');
	$main->appendChild($s = $doc->createElement('div', 'South'));
    $s->setAttribute('class', 'nav south');
	$main->appendChild($se = $doc->createELement('div', 'Southeast'));
    $se->setAttribute('class', 'nav south east');
	
	return $main;
}
