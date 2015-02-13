<?hh

namespace blog\system;

use \PDO;

class Database extends PDO {
	public function __construct(?ImmMap $config = null): void {
		if (isset($config) && !is_null($config)) {
			parent::__construct(
				$config->get('type') . ':host=' .
				$config->get('host') . ';dbname=' .
				$config->get('dbname'), 
				$config->get('user'), 
				$config->get('password')
			);
			
			$this->setAttribute(self::ATTR_ERRMODE, self::ERRMODE_EXCEPTION);
		}
	}
}