<?hh // decl

namespace blog\Controller;

use blog\Model\Post;
use blog\system\AbstractController;

class PostPage extends AbstractController {
	public function __construct(?ImmMap $config = null, ?mixed $user = null): void {
		parent::__construct($config, $user); // to use Database
	}
	
	public function index(): void {
		$this->viewVars['post'] 	= Post::withSlug($this->db, $this->get['slug']);
		$this->viewVars['title'] 	= $this->viewVars['post']->getTitle();
		
		$this->view('layout/header', 	$this->viewVars);
		$this->view('post', 			$this->viewVars);
		$this->view('layout/footer');
	}
	
	public function updatePost(): void {	
		if ($this->user === null || $this->user === false)
			return $this->index();
		
		$post = new Post(
			$this->post['id'],
			$this->post['title'],
			$this->post['title'],
			$this->post['text']
		);
		$result = $post->save($this->db);
	
		if ($result === true) {
			$this->redirect($post->getSlug());
		} else {
			if (in_array('empty', $result))
				$this->viewVars['message']['post'] = 'Bitte alle Felder ausfüllen!';
				
			if (in_array('slug', $result))
				$this->viewVars['message']['post'] = 'Titel bereits vorhanden!';
		}
		
		$this->index();
	}
	
	public function deletePost(): void {
		if ($this->user === null || $this->user === false)
			return $this->index();
		
		$post = new Post(
			$this->post['id']
		);
		$post->delete($this->db);
		
		$this->redirect('index.php');
	}
}