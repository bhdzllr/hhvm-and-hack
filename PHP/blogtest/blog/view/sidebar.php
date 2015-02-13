			<div class="sidebar">
				<?php if (isset($message['login'])) : ?>
				<p class="notification"><?php echo $message['login']; ?></p>
				<?php endif; ?>

				<?php if ($loggedIn == true) : ?>
				<form id="login-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
					<fieldset>
						<legend>Sie sind eingeloggt!</legend>
						
						<input type="submit" id="submit-logout" name="submit-logout" value="Logout" />
						<input type="hidden" name="S_METHOD" value="GET" />
					</fieldset>
				</form>
				<?php else : ?>
				<form id="login-form" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
					<fieldset>
						<legend>Admin Login</legend>
						
						<label for="username">Username:</label>
						<input type="text" id="username" name="username" placeholder="Your Username" />
						<label for="password">Passwort:</label>
						<input type="password" id="password" name="password" placeholder="Your Password" />
						<input type="submit" id="submit-login" name="submit-login" value="Login" />
						<input type="hidden" name="S_METHOD" value="GET" />
					</fieldset>
				</form>
				<?php endif; ?>
			</div>