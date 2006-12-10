<?php

require_once 'config.php';

$name_table = new NameTable();

$names = $name_table->fetchAll();

foreach ($names as $name) {
    $ucfirst_value = ucfirst(strtolower($name->value));
    if ($name->value !== $ucfirst_value) {
        $name->value = $ucfirst_value;
        $name->save();
    }
}
