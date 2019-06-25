<main class="admin">
	<?php require 'adminLeft.html.php'; ?>
		<section class="right">
			<h2>Welcome <?=$_SESSION['username']?></h2>
			<p>Quick Menu</p>
			<button onclick="window.location.href = '/category/edit';">Create Category</button>
			<button onclick="window.location.href = '/furniture/edit';">Create Furniture</button>
			<button onclick="window.location.href = '/news/edit';">Create News Article</button>
		</section>
</main>
