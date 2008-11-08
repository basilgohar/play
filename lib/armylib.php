<?php

$unit_rankings = array(
    'private',
    'corporal',
    'sergeant',
    'warrant officer',
    'chief warrant officer',
    'lieutenant',
    'captain',
    'major',
    'lieutenant colonel',
    'colonel',
    'lietenant general',
    'general'
);

$hierarchy = array(
    'team' => array(
        'leader' => 'corporal',
        'consistency' => null,
        'size' => 4 //  4 soldiers
    ),
    'squad' => array(
        'leader' => 'sergeant',
        'consistency' => 'team',
        'size' => 2 // 8 soldiers
    ),
    'platoon' => array(
        'leader' => 'lieutenant',
        'consistency' => 'squad',
        'size' => 4 //  32 soldiers
    ),
    'battalion' => array(
        'leader' => 'captain',
        'consistency' => 'platoon',
        'size' => 20    // 640 soldiers
    ),
    'brigade' => array(
        'leader' => 'colonel',
        'consistency' => 'battalion',
        'size' => 4 // 2560 soldiers
    ),
    'corps' => array(
        'leader' => 'lieutenant general',
        'consistency' => 'brigade',
        'size' => 4 // 10240 soldiers
    ),
    'army' => array(
        'leader' => 'general',
        'consistency' => 'corps',
        'size' => 4 // 40960 soldiers
    )
);
