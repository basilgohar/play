<?php

require_once 'config.php';

foreach ($tables_sql as $table_name => $table_sql) {
    $db->query($table_sql);
}

/*
if (null !== $db_tables) {
    foreach ($db_tables as $table_name => $table_attributes) {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . $table_name . '` (';
        foreach ($table_attributes as $attributes_type => $attribute_values) {
            switch ($attributes_type) {
                default:
                    break;
                case 'columns':
                    foreach ($attribute_values as $column_name => $column_nature) {
                        if (is_string($column_nature)) {
	                        switch ($column_nature) {
	                            default:
	                                break;
	                            case 'integer':
	                                $sql .= '`' . $column_name . '` int(10) unsigned not null';
	                                if ('id' === $column_name) {
	                                    $sql .= ' auto_increment';
	                                } else {
	                                    $sql .= " default '0'";
	                                }
	                                break;
	                            case 'string':
	                                $sql .= '`' . $column_name . "` varchar(255) not null default ''"; 
	                                break;
	                        }
                        } else if (is_array($column_nature)) {
                            
                        } else {
                            
                        }
                    }
                    break;
                case 'keys':
                    break;
            }
        }        
        $sql .= ')';
    }
}
*/