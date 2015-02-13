<?php

namespace blog\Controller;

use blog\Model\Post;
use blog\system\AbstractController;

class BlogPage extends AbstractController {
	public function __construct($config = null, $user = null) {
		parent::__construct($config, $user); // to use Database
	}
	
	public function index() {	
		$this->viewVars['posts'] = Post::getAll($this->db);
		$this->viewVars['title'] = 'Alle Posts';

		$this->view('layout/header', 	$this->viewVars);
		$this->view('index', 			$this->viewVars);
		$this->view('layout/footer');
	}
	
	public function createPost() {
		if ($this->user === null || $this->user === false)
			return $this->index();

		$post = new Post(
			null,
			$this->post['title'],
			$this->post['title'],
			$this->post['text'],
			$this->user->getUsername()
		);
		$result = $post->save($this->db);

		if ($result === true) {
			$this->viewVars['message']['post'] = 'Post erfolgreich erstellt!';
		} else {
			if (in_array('empty', $result))
				$this->viewVars['message']['post'] = 'Bitte alle Felder ausfüllen!';
				
			if (in_array('slug', $result))
				$this->viewVars['message']['post'] = 'Titel bereits vorhanden!';
		}
		
		$this->index();
	}
	
	public function createAutoPosts() {
		$rand = rand();
	
		$post = new Post(
			null,
			'Test Title #' . $rand,
			'test-title-' . $rand,
			'Lorem ipsum dolor sit amet, consetetur sadipscing elitr 
			sed diam nonumy eirmod tempor invidunt ut labore et dolore
			magna aliquyam erat, sed diam voluptua At vero eos et 
			accusam et justo duo dolores et ea rebum Stet clita kasd gubergren, 
			no sea takimata sanctus est Lorem ipsum dolor sit amet. Lorem ipsum 
			dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod 
			tempor invidunt ut labore et dolore magna aliquyam erat, sed diam 
			voluptua. At vero eos et accusam et justo duo dolores et ea rebum. 
			Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum 
			dolor sit amet. Lorem ipsum dolor sit amet, consetetur sadipscing 
			elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore 
			magna aliquyam erat, sed diam voluptua. At vero eos et accusam et 
			justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea 
			takimata sanctus est Lorem ipsum dolor sit amet.   
			Duis autem vel eum iriure /dolor in hendrerit in vulputate velit esse 
			molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero
			eros et accumsan et iusto odio dignissim qui blandit praesent luptatum
			zzril delenit augue duis dolore te feugait nulla facilisi. Lorem ipsum
			dolor sit amet.',
			'admin'
		);
		$result = $post->save($this->db);

		if ($result === true) {
			$this->viewVars['message']['post'] = 'Post erfolgreich erstellt!';
		} else {
			if (in_array('empty', $result))
				$this->viewVars['message']['post'] = 'Bitte alle Felder ausfüllen!';
				
			if (in_array('slug', $result))
				$this->viewVars['message']['post'] = 'Titel bereits vorhanden!';
		}
		
		$this->index();
	}
}