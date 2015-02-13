<?hh

namespace blog\system;

use blog\Model\User;
use blog\Controller\BlogPage;
use blog\Controller\PostPage;

class Dispatcher {
	private ?mixed 				$user		= null;
	private ?BlogPage			$blog;
	private ?PostPage			$post;
	private ?string 			$_METHOD 	= null;

	public function __construct(
		private ?ImmMap $config = null
	): void {
		$this->dispatch();
	}
	
	private function dispatch(): void {	
		if (isset($_POST['S_METHOD'])) {
			$this->_METHOD = $_POST['S_METHOD'];
		} else {
			$this->_METHOD = null;
		}
	
		if (is_null($this->_METHOD)) {
			$this->get();
		} else {
			switch ($this->_METHOD) {
				case 'POST':
					$this->post();
					break;
				case 'PUT':
					$this->put();
					break;
				case 'DELETE':
					$this->delete();
					break;
				default:
					$this->get();
					break;
			}
		}
	}
	
	private function post(): void {
		if (isset($_POST['submit-post'])) {
			$this->blog = new BlogPage($this->config, User::loggedIn());
			$this->blog->createPost();
		}
	}
	
	private function get(): void {	
		if (isset($_POST['submit-login'])) {		
			$this->user = User::authenticate(
				$_POST['username'], 
				$_POST['password'], 
				$this->config
			);
		} else if (isset($_POST['submit-logout'])) {
			User::logout();
		} else {
			$this->user = User::loggedIn();
		}
		
		if (isset($_GET['slug']) && $_GET['slug'] == 'autoPosts') {
			$this->blog = new BlogPage($this->config, $this->user);
			$this->blog->createAutoPosts();
		} else if (isset($_GET['slug'])) {
			$this->post = new PostPage($this->config, $this->user);
			$this->post->index();
		} else {
			$this->blog = new BlogPage($this->config, $this->user);
			$this->blog->index();
		}
	}
	
	private function put(): void {
		if (isset($_POST['submit-post'])) {
			$this->post = new PostPage($this->config, User::loggedIn());
			$this->post->updatePost();
		}
	}
	
	private function delete(): void {
		if (isset($_POST['submit-delete'])) {
			$this->post = new PostPage($this->config, User::loggedIn());
			$this->post->deletePost();
		}
	}
}