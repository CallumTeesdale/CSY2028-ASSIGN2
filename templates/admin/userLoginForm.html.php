<main class="home">
	<form action="" method="post">
		<label>Username:</label>
		<input type="text" name="user[username]" value="<?=$user->username ?? ''?>" />
		<label>Password:</label>
		<input type="password" name="user[password]" value="<?=$user->password ?? ''?>" />
		<input type="submit" value="Login"> </form>
</main>
