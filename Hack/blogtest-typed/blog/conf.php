<?hh

return $config = array(
	'credentials' => array(
		'user_id'  => '1',
		'username' => 'admin',
		'password' => 'admin',
	),
	'database' => array(
		'type' 			=> 'mysql',
		'host' 			=> 'localhost',
		'dbname'		=> 'blog',
		'user' 			=> 'root',
		'password' 		=> '',
	),
	'viewPath' => 'blog' . DIRECTORY_SEPARATOR . 'view',
);