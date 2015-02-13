<?hh

return $config = ImmMap {
	'credentials' => ImmMap {
		'user_id'  => '1',
		'username' => 'admin',
		'password' => 'admin',
	},
	'database' => ImmMap {
		'type' 			=> 'mysql',
		'host' 			=> 'localhost',
		'dbname'		=> 'blog',
		'user' 			=> 'root',
		'password' 		=> '',
	},
	'viewPath' => 'blog' . DIRECTORY_SEPARATOR . 'view',
};