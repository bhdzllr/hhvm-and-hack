<?hh

error_reporting(E_ALL); 
$timeStart = microtime(true);

class Foo {
	public function bar() {
	}
}

$i = 0;
while ($i < 1000) {
	$obj = new Foo();
	++$i;
}

$timeEnd = microtime(true);
$time = $timeEnd - $timeStart;
echo '<p>' . $time . ' Sekunden ' . '<br />' . ($time * 1000000) . ' [&micro;s]</p>';