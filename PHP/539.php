<?php

error_reporting(E_ALL); 
$timeStart = microtime(true);

try {
	$db = new PDO('mysql:host=localhost;dbname=test', 'root', '');
} catch (PDOException $e) {
	echo $db->errorInfo();
	echo $e->getMessage();
	die();
}

$drop = 'DROP TABLE IF EXISTS `test`';
$create = 'CREATE TABLE `test` (
	`id` INT(14) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`value1` VARCHAR(25) NOT NULL,
	`value2` VARCHAR(25) NOT NULL,
	`value3` VARCHAR(25) NOT NULL
) CHARACTER SET utf8 COLLATE utf8_general_ci';

$db->exec($drop);
$db->exec($create);

$insert = $db->prepare('
	INSERT INTO 
		`test`
		(`value1`, `value2`, `value3`)
	VALUES
		(:value1, :value2, :value3)
');
$first = 'First Value';
$second = 'Second Value';
$third = 'Third Value';
$insert->bindParam(':value1', $first, PDO::PARAM_STR);
$insert->bindParam(':value2', $second, PDO::PARAM_STR);
$insert->bindParam(':value3', $third, PDO::PARAM_STR);
$insert->execute();

$select = $db->prepare('
	SELECT
		*
	FROM
		`test`
');
$select->execute();

foreach ($select->fetchAll() as $record) {
	var_dump($record);
}

$timeEnd = microtime(true);
$time = $timeEnd - $timeStart;
echo '<p>' . $time . ' Sekunden ' . '<br />' . ($time * 1000000) . ' [&micro;s]</p>';