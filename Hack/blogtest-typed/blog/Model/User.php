<?hh

namespace blog\Model;

class User {
	private string 	$id;
	private string 	$username;
	private bool	$loggedIn = false;
	
	public function __construct(string $id, string $username): void {
		$this->id 		= $id;
		$this->username = $username;
		$this->loggedIn = true;
	}
	
	public function getId(): string {
		return $this->id;
	}
	
	public function getUsername(): string {
		return $this->username;
	}
	
	public function isLoggedIn(): bool {
		return $this->loggedIn;
	}
	
	public static function authenticate(string $username, string $password, ?array $config = null): mixed {
		if (isset($config) && !is_null($config)) {
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
	
	public static function loggedIn(): ?User {
		session_start();
		
		if (isset($_SESSION['user'])) {
			return $_SESSION['user'];
		}

		return null;
	}
	
	public static function logout(): void {
		session_start();
		session_destroy();
	}
}