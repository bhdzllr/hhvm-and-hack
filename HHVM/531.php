<?php

error_reporting(E_ALL); 
$timeStart = microtime(true);

$hello = 'Hello';
$world = 'World!';
$just = 'Just';
$simpleTest = 'a simple Test';

$a = 1234;
$b = 5678;
$c = $a + $b;
$d = $a * $b;

echo $hello . ' ' . $world . ' ' . $just . ' ' . $simpleTest . '.<br />';
echo 'First: ' . $c . '; Second: ' . $d;
echo '<br />';
echo '3' + '7';

$timeEnd = microtime(true);
$time = $timeEnd - $timeStart;
echo '<p>' . $time . ' Sekunden ' . '<br />' . ($time * 1000000) . ' [&micro;s]</p>';