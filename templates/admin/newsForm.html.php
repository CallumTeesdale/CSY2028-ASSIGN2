<main class="admin">
	<?php require 'adminLeft.html.php'; ?>
		<section class="right">
			<h2>Edit news</h2>
			<form action="" method="POST" enctype="multipart/form-data">
				<input type="hidden" name="news[id]" value="<?=$news->id ?? '' ?>>" />
        <input type="hidden" name="news[adminId]" value="<?=$news->adminId ?? '' ?>>" />
				<label>Title</label>
        <input type="text" name="news[title]" value="<?=$news->title ?? ''?>" />
        <label>Description</label>
        <textarea name="news[description]"><?=$news->description ?? ''?></textarea>
        <label>Image</label>
        <input type="file" name="image1" />
        <input type="submit" name="submit" value="Save news" /> </form>
		</section>
</main>
