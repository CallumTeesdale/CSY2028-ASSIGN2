<main class="admin">
	<?php require 'adminLeft.html.php'; ?>
		<section class="right">
		<?php if (count($errors) > 0) { ?>
        <p>Error in adding category:</p>
        <ul>
            <?php foreach ($errors as $error) { ?>
                <li><?= $error ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
			<h2>Edit Category</h2>
			<form action="" method="POST">
				<input type="hidden" name="category[id]" value="<?=$category->id ?? ''?>>" />
				<label>Name</label>
				<input type="text" name="category[name]" value="<?=$category->name ?? ''?>" />
				<input type="submit" name="submit" value="Save Category" /> </form>
		</section>
</main>
