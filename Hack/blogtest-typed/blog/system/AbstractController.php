<?hh

namespace blog\system;

abstract class AbstractController {
	protected ?array 	$config;
	protected Database 	$db;
	protected ?mixed	$user;
	protected string	$get;
	protected string	$post;
	
	protected $viewVars = array(
		'title'		=> null,
		'loggedIn'	=> false,
		'message'	=> array(),
	);
	
	public function __construct(array $config, ?mixed $user = null): void {
		$this->get		= $_GET;
		$this->post		= $_POST;
		$this->config 	= $config;
		$this->user		= $user;
		
		if (!is_null($this->config)) {
			try {
				$this->db = new Database($this->config['database']);
			} catch (PDOException $e) {
				echo $e->getMessage();
				die();
			}
		}
			
		if ($this->user === false) {
			$this->viewVars['message']['login'] = 'Login falsch';
		} else if ($this->user !== null) {
			$this->viewVars['loggedIn'] = true;
		}
	}

	protected function view(string $filename, array $viewVars = array()): void {
		if (isset($viewVars)) 
			extract($viewVars);
		
		require $this->config['viewPath'] . DIRECTORY_SEPARATOR . $filename . '.php';
	}
	
	protected function redirect($path): void {
		header('Location: ' . $path);
	}
}