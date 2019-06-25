<main class="admin">
	<?php require 'adminLeft.html.php'; ?>
		<section class="right">
		<?php if (count($errors) > 0) { ?>
        <p>Error in adding furniture:</p>
        <ul>
            <?php foreach ($errors as $error) { ?>
                <li><?= $error ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
			<h2>Add Furniture</h2>
			<?php
for ($i = 1; $i < 5; $i++) {
  if (isset($_GET['id']) && file_exists("images/furniture/" . $furniture->id . "_$i.jpg")) { ?>
				<label for "image">Current image
					<?=$i ?>
				</label> <img name="image" src="../images/furniture/<?=$furniture->id ."_".$i?>.jpg" height="100" width="100" />
				<?php }
        } ?>
					<form action="" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="furniture[id]" value="<?=$furniture->id ?? ''?>" />
						<label>Name</label>
						<input type="text" name="furniture[name]" value="<?=$furniture->name ?? ''?>" />
						<label>Description</label>
						<textarea name="furniture[description]"><?=$furniture->description ?? ''?></textarea>
						<label>Price</label>
						<input type="text" name="furniture[price]" value="<?=$furniture->price ?? ''?>" />
						<label>Category</label>
						<select name="furniture[categoryId]">
							<?php
  foreach ($categories as $category) {?>
								<option value="<?=$category->id ?? ''?>">
									<?=$category->name ?? ''?>
								</option>
								<?php
}?>
						</select>
						<?php
  if (isset($_GET['id'])) {
    if ($furniture->archived == true) {?>
							<label>Archived</label>
							<input type="hidden" name="furniture[archived]" value="0" />
							<input type="checkbox" name="furniture[archived]" value="1" checked>
							<?php
}else {?>
								<label>Archived</label>
								<input type="hidden" name="furniture[archived]" value="0" />
								<input type="checkbox" name="furniture[archived]" value="1">
								<?php
}
}else {?>
									<label>Archived</label>
									<input type="hidden" name="furniture[archived]" value="0" />
									<input type="checkbox" name="furniture[archived]" value="1">
									<?php  }?>
									<label>Condition</label>
										<select name="furniture[cond]">
											<option value="NEW">New</option>
											<option value="SECOND HAND">Second Hand</option>
										</select>
										<label>Image 1</label>
										<input type="file" name="image1" />
										<label>Image 2</label>
										<input type="file" name="image2" />
										<label>Image 3</label>
										<input type="file" name="image3" />
										<label>Image 4</label>
										<input type="file" name="image4" />
										<input type="submit" name="submit" value="Add" /> </form>
		</section>
</main>
