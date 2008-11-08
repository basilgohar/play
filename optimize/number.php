<?php

class Number
{
    protected $value = 0;

    public function __construct($initial_value = 0)
    {
        $this->value = $initial_value;
    }

    public function increment()
    {
        $this->add(1);
    }

    public function decrement()
    {
        $this->subtract(1);
    }

    public function add($add_value = 0)
    {
        $this->value = $this->value + $add_value;
    }

    public function subtract($subtract_value = 0)
    {
        $this->value = $this->value - $subtract_value;
    }

    public function __toString()
    {
        return (string) $this->value;
    }
}

$start_time = microtime(true);

define('COUNT', 100000000);

//$number = new Number;
$number = 0;

for ($i = 0; $i < COUNT; ++$i) {
    //$number->increment();
    ++$number;
}

$total_time = microtime(true) - $start_time;

echo 'Processed ' . $i . ' iterations in ' . $total_time . ' seconds (' . $i/$total_time . ' iterations/second)' . "\n";
