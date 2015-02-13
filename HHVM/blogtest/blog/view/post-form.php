		<?php if ($loggedIn === true) : ?>
			<?php if (isset($message['post'])) :?>
		<p class="notification"><?php echo $message['post']; ?></p>
			<?php endif; ?>
		<form id="post-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
			<fieldset>
				<legend>Neuer Artikel</legend>
				<label for="title">Titel:</label>
				<input type="text" id="title" name="title" placeholder="Post Titel"/>
				<em><?php echo $this->user->getUsername(); ?>, <?php echo date('Y-m-d h:i:s', time()); ?></em>
				<label for="text">Artikeltext:</label>
				<textarea id="text" name="text" rows="3" cols="30" placeholder="Text..."></textarea>
				<input type="submit" id="submit-post" name="submit-post" value="Veröffentlichen" />
				<input type="hidden" name="S_METHOD" value="POST" />
			</fieldset>
		</form>
		<?php endif; ?>