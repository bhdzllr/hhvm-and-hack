<?hh

namespace blog\system;

use \PDO;

class Database extends PDO {
	public function __construct(?array $config = null): void {
		if (isset($config) && !is_null($config)) {
			parent::__construct(
				$config['type'] . ':host=' .
				$config['host'] . ';dbname=' .
				$config['dbname'], 
				$config['user'], 
				$config['password']
			);
			
			$this->setAttribute(self::ATTR_ERRMODE, self::ERRMODE_EXCEPTION);
		}
	}
}