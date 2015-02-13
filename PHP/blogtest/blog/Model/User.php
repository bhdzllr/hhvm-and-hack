<?php

namespace blog\Model;

class User {
	private $id;
	private $username;
	private $loggedIn = false;
	
	public function __construct($id, $username) {
		$this->id 		= $id;
		$this->username = $username;
		$this->loggedIn = true;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getUsername() {
		return $this->username;
	}
	
	public function isLoggedIn() {
		return $this->loggedIn;
	}
	
	public static function authenticate($username, $password, $config = null) {	
		if (isset($config)) {	
			if ($username == $config['credentials']['username']
				&& $password == $config['credentials']['password']
			) {
				$self = new self(
					$config['credentials']['user_id'], 
					$username
				);
				
				session_start();
				$_SESSION['user'] = $self;

				return $self;
			}
		}
		
		return false;
	}
	
	public static function loggedIn() {
		session_start();
		
		if (isset($_SESSION['user'])) {
			return $_SESSION['user'];
		}

		return null;
	}
	
	public static function logout() {
		session_start();
		session_destroy();
	}
}