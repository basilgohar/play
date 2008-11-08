<?php

require_once 'config.php';
require_once 'tables.php';

if (null !== $db_tables) {
    foreach ($db_tables as $table_name => $table_attributes) {
        $sql = 'CREATE TABLE IF NOT EXISTS `' . $table_name . '` (' . "\n";
        foreach ($table_attributes as $attributes_type => $attribute_values) {
            switch ($attributes_type) {
                default:
                    break;
                case 'columns':
                    foreach ($attribute_values as $column_name => $column_nature) {
                        if (is_string($column_nature)) {
                            switch ($column_nature) {
                                default:
                                    throw new Exception('Unknown column nature: ' . $column_nature);
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
                                case 'datetime':
                                    $sql .= '`' . $column_name . "` datetime not null default '0000-00-00 00:00:00'";
                                    break;
                            }
                        } else if (is_array($column_nature)) {
                            $sql .= '`' . $column_name . "` enum('" . implode("','", $column_nature) . "') not null";
                        } else {
                            throw new Exception('Unknown column nature: ' . $column_nature);
                        }
                        $sql .= ',' . "\n";
                    }                    
                    break;
                case 'keys':
                    foreach ($attribute_values as $column_name => $key_type) {
                        switch ($key_type) {
                            default:
                                $sql .= 'KEY `' . $column_name . '` (`' . $column_name . '`)';
                                break;
                            case 'primary':
                                $sql .= 'PRIMARY KEY (`' . $column_name . '`)';
                                break;
                        }
                        $sql .= ',' . "\n";
                    }
                    break;
            }
        }
        $sql = substr($sql, 0, -2);
        $sql .= "\n";
        $sql .= ')';
        $db->query($sql);
    }
}
