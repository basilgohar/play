<?php

$start_time = microtime(true);

set_time_limit(0);

//define('COUNT', pow(26, 6) + pow(26, 5) + pow(26, 4) + pow(26, 3) + pow(26, 2) + pow(26, 1));
define('COUNT', 1000000);
define('INCREMENT_DIVISOR', 80);
define('INCREMENT_UPDATE', COUNT/INCREMENT_DIVISOR);
define('CONNECTOR', 'zend_db');
if (file_exists('/dev/shm')) {
    define('PATH', '/dev/shm');
}
define('FILENAME', 'something');

switch (CONNECTOR) {
   case 'pdo':
       $dbh = new PDO('mysql:host=localhost;dbname=local', 'root', 'g0har1');

       $dbh->query('TRUNCATE TABLE `md5`');

       $statement = $dbh->prepare("INSERT INTO `md5` (`name`, `hash`) VALUES (:name, :hash)");
       $statement->bindParam(':name', $name);
       $statement->bindParam(':hash', $hash);
       break;
   case 'mysql':
       mysql_connect('localhost', 'root', 'g0har1');
       mysql_select_db('local');

       mysql_query('TRUNCATE TABLE `md5`');
       break;
   case 'file':
    if (defined('PATH')) {
        $fp = fopen(PATH . PATH_SEPARATOR . FILENAME, 'w');
    } else {
        $fp = fopen(FILENAME, 'w');
    }
    break;
}

$string = 'a';
echo 'Each "." means ' . floor(INCREMENT_UPDATE) . ' iterations have been processed (there should be ' . INCREMENT_DIVISOR . ' total)' . "\n";
for ($i = 0; $i < COUNT; ++$i) {
   if ($i > INCREMENT_UPDATE && $i % INCREMENT_UPDATE === 0) {
       echo '.';
   }
   $name = $string++;
   $hash = md5($name);
   switch (CONNECTOR) {
       case 'mysql':
           $sql = "INSERT INTO `md5` (`name`, `hash`) VALUES ('$name', '$hash')";
           mysql_query($sql);
           break;
       case 'pdo':
           $statement->execute();
           break;
       case 'file':
           $line = $hash . "\t" . $name . "\n";
           fwrite($fp, $line);
           break;
   }
}
echo "\n";

$total_time = microtime(true) - $start_time;
echo 'Completed ' . $i . ' iterations in ' . $total_time . ' seconds (' . $i/$total_time . ' iterations per second)' . "\n";


