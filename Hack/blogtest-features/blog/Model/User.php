<?hh

namespace blog\Model;

class User {
	private bool	$loggedIn = false;
	
	public function __construct(
		private string $id, 
		private string $username
	): void {}
	
	public function getId(): string {
		return $this->id;
	}
	
	public function getUsername(): string {
		return $this->username;
	}
	
	public function isLoggedIn(): bool {
		return $this->loggedIn;
	}
	
	public static function authenticate(string $username, string $password, ?ImmMap $config = null): mixed {
		if (isset($config) && !is_null($config)) {
			if ($username == $config->get('credentials')->get('username')
				&& $password == $config->get('credentials')->get('password')
			) {
				$self = new self(
					$config->get('credentials')->get('user_id'), 
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