<?php

$count = 1000000;

for ($i = 0; $i < $count; ++$i) {
    define(md5($i), $i);
}

print_r(get_defined_constants());
