<?php

require_once 'config.php';

if (! isset($argv)) {
    exit('optimize cannot be run in this context' . "\n");
}

$number_of_arguments = count($argv);

if ($number_of_arguments === 1) {
    exit('No arguments passed to optimize' . "\n");
}

if (! isset($argv[2])) {
    $iterations = DEFAULT_ITERATIONS;
} else if (! is_numeric($argv[2])) {
    exit('Invalid value "' . $argv[2] . '" for iterations' . "\n");
} else {
    $iterations = (int) $argv[2];
}

if (! isset($argv[3])) {
    $subtest = 'default';
} else {
    $subtest = $argv[3];
}

switch ($argv[1]) {
    default:
        exit('Invalid test "' . $argv[1] . '" specified' . "\n");
        break;
    case 'for':
        require_once 'for.php';
        break;
    case 'while':
        require_once 'while.php';
        break;
    case 'isset':
        require_once 'isset.php';
        break; 
    case 'strlen':
        require_once 'strlen.php';
        break;
}

$total_time = round(microtime(true) - $start_time, 2);

$iterations_per_second = round($iterations/$total_time);

echo "Processed $iterations iterations in $total_time seconds ($iterations_per_second iterations/second)\n";
