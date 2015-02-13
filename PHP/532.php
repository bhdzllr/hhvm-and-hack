<?php

error_reporting(E_ALL); 
$timeStart = microtime(true);

$check = true;
$strin = 'World';
$value = 100;

if ($check == true) {
	echo 'yep';
}

if ($check == false) {
	echo 'nope';
}

if ($strin == 'World') {
	echo 'yep';
}

if ($strin != 'World') {
	echo 'nope';
}

if ($value == 100) {
	echo 'yep';
}

if ($value != 100) {
	echo 'nope';
}

$timeEnd = microtime(true);
$time = $timeEnd - $timeStart;
echo '<p>' . $time . ' Sekunden ' . '<br />' . ($time * 1000000) . ' [&micro;s]</p>';