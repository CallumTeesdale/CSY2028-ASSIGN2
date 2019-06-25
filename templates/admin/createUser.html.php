<main class="admin">
	<?php require 'adminLeft.html.php'; ?>
		<section class="right">
			<form action="" method="post">
				<input type="hidden" name="user[id]" value="<?=$user->id ?? ''?>" required/>
				<label>Username:</label>
				<input type="text" name="user[username]" value="<?=$user->username ?? ''?>" required/>
				<?php if (isset($_GET['id'])){ ?>
					<?php }elseif(!isset($_GET['id'])){ ?>
						<label>Password:</label>
						<input type="password" name="user[password]" value="<?=$user->password ?? ''?>" required/>
						<?php } ?>
							<label>First Name:</label>
							<input type="text" name="user[fname]" value="<?=$user->fname ?? ''?>" required/>
							<label>Last Name:</label>
							<input type="text" name="user[lname]" value="<?=$user->lname ?? ''?>" required />
							<label>Email:</label>
							<input type="email" name="user[email]" value="<?=$user->email ?? ''?>" required/>
							<label>Phone Number:</label>
							<input type="text" name="user[contact_no]" value="<?=$user->contact_no ?? ''?>" required/>
							<label>Address:</label>
							<textarea name="user[address]" rows="3" cols="40" required>
								<?=$user->address ?? ''?>
							</textarea>
							<input type="submit" value="Register"> </form>
		</section>
</main>
