<?php

namespace blog\system;

use blog\Model\User;
use blog\Controller\BlogPage;
use blog\Controller\PostPage;

class Dispatcher {
	private $config = null;
	private $user	= null;
	private $blog 	= null;
	private $post	= null;

	public function __construct($config = null) {	
		$this->config = $config;
		$this->dispatch();
	}
	
	private function dispatch() {
		if (isset($_POST['S_METHOD'])) {
			$_METHOD = $_POST['S_METHOD'];
		} else {
			$_METHOD = null;
		}
	
		switch ($_METHOD) {
			case 'POST';
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
	
	private function post() {
		if (isset($_POST['submit-post'])) {
			$this->blog = new BlogPage($this->config, User::loggedIn());
			$this->blog->createPost();
		}
	}
	
	private function get() {	
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
	
	private function put() {
		if (isset($_POST['submit-post'])) {
			$this->post = new PostPage($this->config, User::loggedIn());
			$this->post->updatePost();
		}
	}
	
	private function delete() {
		if (isset($_POST['submit-delete'])) {
			$this->post = new PostPage($this->config, User::loggedIn());
			$this->post->deletePost();
		}
	}
}