<?hh

namespace blog\system;

abstract class AbstractController {
	protected Database 	$db;
	protected string	$get;
	protected string	$post;
	
	protected $viewVars = Map {
		'title'		=> null,
		'loggedIn'	=> false,
		'message'	=> Map {},
	};
	
	public function __construct(
		protected ImmMap $config, 
		protected ?mixed $user = null
	): void {
		$this->get		= $_GET;
		$this->post		= $_POST;
		
		if (!is_null($this->config)) {
			try {
				$this->db = new Database($this->config->get('database'));
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

	protected function view(string $filename, Map $viewVars = Map {}): void {
		if (isset($viewVars)) 
			extract($viewVars);
		
		require $this->config->get('viewPath') . DIRECTORY_SEPARATOR . $filename . '.php';
	}
	
	protected function redirect(string $path): void {
		header('Location: ' . $path);
	}
}