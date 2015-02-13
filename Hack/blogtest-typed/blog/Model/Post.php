<?hh

namespace blog\Model;

use blog\system\Database;

class Post {
	private ?string $id;
	private ?string $title;
	private ?string $slug;
	private ?string $text;
	private ?string $author;
	private ?string $created;
	private ?string $modified;
	
	private $db;
	private $notifications = array();
	
	public function __construct(?string $id = null, ?string $title = null, ?string $slug = null, ?string $text = null, ?string $author = null, ?string $created = null): void {
		$this->id		= $id;
		$this->title	= $title;
		$this->slug		= $slug;
		$this->text		= $text;
		$this->author	= $author;
		$this->created	= $created;
	}
		
	public function setId(string $id): void {
		$this->id = $id;
	}
	
	public function getId(): ?string {
		return $this->id;
	}

	public function setTitle(string $title): void {
		$this->title = $title;
	}
	
	public function getTitle(): ?string {
		return $this->title;
	}

	public function setSlug(string $slug): void {
		$this->slug = $slug;
		$this->transformSlug();
	}
	
	public function getSlug(): ?string {
		return $this->slug;
	}

	public function setText(string $text): void {
		$this->text = $text;
	}
	
	public function getText(?int $char = null): ?string {
		if (isset($char))
			return substr($this->text, 0, $char);
		
		return $this->text;
	}
	
	public function setAuthor($author): void {
		$this->author = $author;
	}
	
	public function getAuthor(): ?string {
		return $this->author;
	}

	public function getCreated(): ?string {
		return $this->created;
	}
	
	public function getModified(): ?string {
		return $this->modified;
	}
	
	public function save(Database $db): mixed {
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
	
	private function insert(): bool {
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
	
	private function update(): bool {
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
	
	public function delete(Database $db): bool {
		$delete = $db->prepare('
			DELETE FROM
				`posts`
			WHERE
				`id` = :id
		');
		$delete->bindParam(':id', $this->id);
		return $delete->execute();
	}
	
	public static function getAll(Database $db): array {		
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
	
	public static function withID(Database $db, string $id): Post {
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
	
	public static function withSlug(Database $db, string $slug): Post {
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
	
	public function getComments(): void {
		// Kommentare auslesen, als Array zurückgeben
	}
	
	private function isValid(): bool {
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
	
	private function transformSlug(): void {
		$this->slug = str_replace(' ', '-', $this->slug);
		$this->slug = preg_replace('/[^a-zA-Z0-9_-]+/', '', $this->slug);
	}
}