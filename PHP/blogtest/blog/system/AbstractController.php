<?php

namespace blog\system;

use blog\Model\User;

abstract class AbstractController {
	protected $config;
	protected $db;
	protected $user;
	protected $viewVars = array(
		'title'		=> null,
		'loggedIn'	=> false,
		'message'	=> array(),
	);
	
	public function __construct($config, $user = null) {
		$this->get		= $_GET;
		$this->post		= $_POST;
		$this->config 	= $config;
		$this->user		= $user;
		
		if (isset($this->config['database'])) {
			try {
				$this->db = new Database($this->config['database']);
			} catch (PDOException $e) {
				echo $e->getMessage();
				echo $this->db->errorInfo();
				die();
			}
		}
			
		if ($this->user === false) {
			$this->viewVars['message']['login'] = 'Login falsch';
		} else if ($this->user !== null) {
			$this->viewVars['loggedIn'] = true;
		}
	}

	protected function view($filename, $viewVars = array()) {
		if (isset($viewVars)) {
			foreach ($viewVars as $key => $value)
				$$key = $value;
			
			// unset($viewVars);
		}
		
		include $this->config['viewPath'] . DIRECTORY_SEPARATOR . $filename . '.php';
	}
	
	protected function redirect($path) {
		header('Location: ' . $path);
	}
}