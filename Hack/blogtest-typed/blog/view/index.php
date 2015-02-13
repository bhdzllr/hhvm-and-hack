		<main role="main">		
			<div class="article-wrapper">
				<?php $this->view('post-form', $this->viewVars); ?>
			
				<?php foreach ($posts as $post ) : ?>
				<article>
					<header>
						<h2><?php echo $post->getTitle(); ?></h2>
						<em><?php echo $post->getAuthor(); ?>, <?php echo $post->getCreated(); ?></em>
					</header>
					
					<p><?php echo $post->getText(255); ?>...</p>
					<a 
						href="<?php echo $post->getSlug(); ?>" 
						title="<?php echo $post->getTitle(); ?>"
					>Weiterlesen</a>
				</article>	
				<?php endforeach; ?>
				
				<?php if (empty($posts)) : ?>
				<article>
					<p>Keine Einträge vorhanden!</p>
				</article>
				<?php endif; ?>
			</div>
			
			<?php $this->view('sidebar', $this->viewVars); ?>
		</main>