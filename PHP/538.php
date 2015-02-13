<?php

error_reporting(E_ALL); 
$timeStart = microtime(true);

$text = '
	Lorem ipsum dolor sit amet, consetetur sadipscing elitr 
	sed diam nonumy eirmod tempor invidunt ut labore et dolore
	magna aliquyam erat, sed diam voluptua At vero eos et 
	accusam et justo duo dolores et ea rebum Stet clita kasd gubergren, 
	no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum 
	dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod 
	tempor invidunt ut labore et dolore magna aliquyam erat, sed diam 
	voluptua. At vero eos et accusam et justo duo dolores et ea rebum. 
	Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum 
	dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing 
	elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore 
	magna aliquyam erat, sed diam voluptua. At vero eos et accusam et 
	justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea 
	takimata sanctus est Lorem ipsum dolor sit amet.   

	Duis autem vel eum iriure /dolor in hendrerit in vulputate velit esse 
	molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero
	eros et accumsan et iusto odio dignissim qui blandit praesent luptatum
	zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum
	dolor sit amet.
';

$path = 'testfile.txt';
$file = fopen($path, 'r+');
rewind($file);
fwrite($file, $text);
fclose($file);

$textFromFile = file_get_contents($path);
var_dump($textFromFile);

$timeEnd = microtime(true);
$time = $timeEnd - $timeStart;
echo '<p>' . $time . ' Sekunden ' . '<br />' . ($time * 1000000) . ' [&micro;s]</p>';