<?php

namespace blog\system;

use \PDO;

class Database extends PDO {
	public function __construct($config = null) {
		if (isset($config)) {
			parent::__construct(
				$config['type'] . ':host=' .
				$config['host'] . ';dbname=' .
				$config['dbname'], 
				$config['user'], 
				$config['password']
			);
			
			$this->setAttribute(self::ATTR_ERRMODE, self::ERRMODE_EXCEPTION);
			
			return true;
		}
		
		return false;
	}
}