		<main role="main">
			<div class="article-wrapper">
				<article>
					<?php if ($loggedIn !== true) : ?>
					<header>
						<h2><?php echo $post->getTitle(); ?></h2>
						<em>von <?php echo $post->getAuthor(); ?>, <?php echo $post->getCreated(); ?></em>
					</header>
					<?php endif; ?>
					
					<?php if ($loggedIn === true) : ?>
						<?php if (isset($message['post'])) :?>
					<p class="notification"><?php echo $message['post']; ?></p>
						<?php endif; ?>
					<form id="post-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
						<fieldset>
							<legend>Artikel ändern</legend>
							<input type="hidden" id="id" name="id" value="<?php echo $post->getId(); ?>" />
							<label for="title">Titel:</label>
							<input type="text" id="title" name="title" value="<?php echo $post->getTitle(); ?>" />
							<em><?php echo $post->getAuthor(); ?>, <?php echo $post->getCreated(); ?></em>
							<label for="text">Artikeltext:</label>
							<textarea id="text" name="text" rows="3" cols="30"><?php echo $post->getText(); ?></textarea>
							<input type="submit" id="submit-post" name="submit-post" value="Ändern" />
							<input type="hidden" name="S_METHOD" value="PUT" />
						</fieldset>
					</form>
					
					<form id="post-delete" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
						<fieldset>
							<legend>Artikel löschen</legend>
							<input type="hidden" id="id" name="id" value="<?php echo $post->getId(); ?>" />
							<input type="submit" id="submit-delete" name="submit-delete" value="Löschen" />
							<input type="hidden" name="S_METHOD" value="DELETE" />
						</fieldset>
					</form>
					<?php else : ?>
					<p><?php echo $post->getText(); ?></p>
					<?php endif; ?>
					<a 
						href="index.php" 
						title="Home"
					>Zurück</a>
				</article>
			</div>
			
			<?php $this->view('sidebar', $this->viewVars); ?>
		</main>