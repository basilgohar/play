<?php
/**
 * Defines the structure of the schema to use in table creation
 */

$db_tables = array (
    'Celltype' => array (
        'columns' => array (
            'id' => 'integer',
            'name' => 'string',
            'description' => 'text'
        ),
        'keys' => array (
            'id' => 'primary'
        )
    ),
    'Cell' => array (
        'columns' => array (
            'id' => 'integer',
            'type_id' => 'integer',
            'coord_x' => 'integer',
            'coord_y' => 'integer',
            'coord_z' => 'integer'
        ),
        'keys' => array (
            'id' => 'primary',
            'type_id' => 'key',
            'coord' => array (
                'coord_x',
                'coord_y',
		'coord_z'
            )
        )
    ),
    'ObjectCell' => array (
        'columns' => array (
            'id' => 'integer',
            'object_id' => 'integer',
            'cell_id' => 'integer'
        ),
        'keys' => array (
            'id' => 'primary',
            'object_id' => 'key',
            'cell_id' => 'key'
        )
    ),
    'Integer' => array (
	'columns' => array (
            'i' => 'integer'
        )
    ),
    'Letter' => array (
        'columns' => array (
            'l' => 'string'
        )
    )
);
