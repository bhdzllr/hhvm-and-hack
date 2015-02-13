<?php

namespace blog\Model;

class Post {
	private $id;
	private $title;
	private $slug;
	private $text;
	private $author;
	private $created;
	private $modified;
	private $notifications = array();
	
	public function __construct($id = null, $title = null, $slug = null, $text = null, $author = null, $created = null) {
		$this->id		= $id;
		$this->title	= $title;
		$this->slug		= $slug;
		$this->text		= $text;
		$this->author	= $author;
		$this->created	= $created;
	}
		
	public function setId($id) {
		return $this->id = $id;
	}
	
	public function getId() {
		return $this->id;
	}

	public function setTitle($title) {
		return $this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}

	public function setSlug($slug) {
		$this->slug = $slug;
		$this->transformSlug();
	}
	
	public function getSlug() {
		return $this->slug;
	}

	public function setText($text) {
		return $this->slug = $slug;
	}
	
	public function getText($char = null) {
		if (isset($char))
			return substr($this->text, 0, $char);
		
		return $this->text;
	}
	
	public function setAuthor($author) {
		return $this->author = $author;
	}
	
	public function getAuthor() {
		return $this->author;
	}

	public function getCreated() {
		return $this->created;
	}
	
	public function getModified() {
		return $this->modified;
	}
	
	public function save($db) {
		$this->db = $db;
		$this->transformSlug();
	
		if ($this->isValid()) {		
			if (isset($this->id)) {
				return $this->update();
			} else {
				return $this->insert();
			}
		}
		
		return $this->notifications;
	}
	
	private function insert() {
		$insert = $this->db->prepare('
			INSERT INTO
				`posts` 
				(`title`, `slug`, `text`, `author`, `created`, `modified`) 
			VALUES 
				(:title, :slug, :text, :author, NOW(), NOW())
		');
		$insert->bindParam(':title',	$this->title,	\PDO::PARAM_STR);
		$insert->bindParam(':slug',		$this->slug, 	\PDO::PARAM_STR);
		$insert->bindParam(':text',		$this->text,	\PDO::PARAM_STR);
		$insert->bindParam(':author',	$this->author,	\PDO::PARAM_STR);

		return $insert->execute();
	}
	
	private function update() {
		$update = $this->db->prepare('
			UPDATE
				`posts`
			SET
				`title` 	= :title, 
				`slug`		= :slug,
				`text`		= :text,
				`modified`	= NOW() 
			WHERE
				`id` = :id
		');
		$update->bindParam(':title',	$this->title,	\PDO::PARAM_STR);
		$update->bindParam(':slug',		$this->slug, 	\PDO::PARAM_STR);
		$update->bindParam(':text',		$this->text,	\PDO::PARAM_STR);
		$update->bindParam(':id',		$this->id);
		
		return $update->execute();
	}
	
	public function delete($db) {
		$delete = $db->prepare('
			DELETE FROM
				`posts`
			WHERE
				`id` = :id
		');
		$delete->bindParam(':id', $this->id);
		return $delete->execute();
	}
	
	public static function getAll($db) {		
		$get = $db->prepare('
			SELECT 
				*
			FROM 
				`posts`
			ORDER BY `created` DESC
		');
		$get->execute();
		
		$posts = array();
		
		foreach ($get->fetchAll() as $post) {
			$posts[] = new self(
				$post['id'],
				$post['title'],
				$post['slug'],
				$post['text'],
				$post['author'],
				$post['created']
			);
		}

		return $posts;
	}
	
	public static function withID($db, $id) {
		$get = $db->prepare('
			SELECT 
				*
			FROM 
				`posts`
			WHERE `id` = :id
		');
		$get->bindParam(':id', $id, \PDO::PARAM_STR);
		$get->execute();
		
		$p = $get->fetch();

		$post = new self(
			$p['id'],
			$p['title'],
			$p['slug'],
			$p['text'],
			$p['author'],
			$p['created']
		);

		return $post;
	}
	
	public static function withSlug($db, $slug) {
		$get = $db->prepare('
			SELECT 
				*
			FROM 
				`posts`
			WHERE `slug` = :slug
		');
		$get->bindParam(':slug', $slug, \PDO::PARAM_STR);
		$get->execute();
		
		$p = $get->fetch();

		$post = new self(
			$p['id'],
			$p['title'],
			$p['slug'],
			$p['text'],
			$p['author'],
			$p['created']
		);

		return $post;
	}
	
	public function getComments() {
		// Kommentare auslesen, als Array zurückgeben
	}
	
	private function isValid() {
		if (empty($this->title)	|| empty($this->text)) {
			$this->notifications[] = 'empty';
			return false;
		} 
		
		$checkSlug = $this::withSlug($this->db, $this->slug);
		$slug = $checkSlug->getSlug();
		
		if (!empty($slug)
			&& $checkSlug->getId() != $this->id
		) {
			$this->notifications[] = 'slug';
			return false;
		}

		return true;
	}
	
	private function transformSlug() {
		$this->slug = str_replace(' ', '-', $this->slug);
		$this->slug = preg_replace('/[^a-zA-Z0-9_-]+/', '', $this->slug);
	}
}