<?php

error_reporting(E_ALL); 
$timeStart = microtime(true);

$values = array(
	'a', 'A',
	'b', 'B',
	'c', 'C',
	'd', 'D',
	'e', 'E',
	'f', 'F',
	'g', 'G',
	'h', 'H',
	'i', 'I',
	'j', 'J',
	'k', 'K',
	'l', 'L',
	'm', 'M',
	'n', 'N',
	'o', 'O',
	'p', 'P',
	'q', 'Q',
	'r', 'R',
	's', 'S',
	't', 'T',
	'u', 'U',
	'v', 'V',
	'w', 'W',
	'x', 'X',
	'y', 'Y',
	'z', 'Z',
);

$i = 0;
while ($i < count($values)) {
	echo $values[$i] . ' ';
	++$i;
}

$timeEnd = microtime(true);
$time = $timeEnd - $timeStart;
echo '<p>' . $time . ' Sekunden ' . '<br />' . ($time * 1000000) . ' [&micro;s]</p>';