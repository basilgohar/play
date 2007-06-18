<?php
/**
 * Defines the structure of the schema to use in table creation
 */

$db_tables = array (
    'Names' => array (
        'columns' => array (
            'id' => 'integer',
            'value' => 'string',
            'type' => array ('female', 'last', 'male')            
        ),
        'keys' => array (
            'id' => 'primary',
            'value' => 'key',
            'type' => 'key'
        )    
    ),
    'People' => array (
        'columns' => array (
            'id' => 'integer',
            'name_first_id' => 'integer',
            'name_last_id' => 'integer',
            'gender' => array('female', 'male'),
            'date_birth' => 'datetime',
            'date_death' => 'datetime'
        ),
        'keys' => array (
            'id' => 'primary',
            'name_first_id' => 'key',
            'name_last_id' => 'key',
            'gender' => 'key'
        )    
    ),
    'Marriages' => array (
        'columns' => array (
            'id' => 'integer',
            'husband_id' => 'integer',
            'wife_id' => 'integer',
            'date_married' => 'datetime',
            'date_divorced' => 'datetime'
        ),
        'keys' => array (
            'id' => 'primary',
            'husband_id' => 'key',
            'wife_id' => 'key'
        )
    ),
    'Families' => array (
        'columns' => array (
            'id' => 'integer',
            'person_id' => 'integer',
            'mother_id' => 'integer',
            'father_id' => 'integer'
        ),
        'keys' => array (
            'id' => 'primary',
            'person_id' => 'key',
            'mother_id' => 'key',
            'father_id' => 'key'
        )
    ),
    'Info' => array (
        'columns' => array (
            'id' => 'integer',
            'key' => 'string',
            'value' => 'string'
        ),
        'keys' => array (
            'id' => 'primary',
            'key' => 'key'
        )
    )
);
