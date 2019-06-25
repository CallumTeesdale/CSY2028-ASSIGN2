<main class="admin">
	<?php require 'adminLeft.html.php';?>
		<section class="right">
			<h2>Furniture</h2> <a class="new" href="/furniture/edit">Add new furniture</a>
			<table>
				<thead>
					<tr>
						<th style="width: 10%">Name</th>
						<th style="width: 10%">Price</th>
						<th style="width: 10%">Archived</th>
						<th style="width: 5%">&nbsp;</th>
						<th style="width: 5%">&nbsp;</th>
					</tr>
					<?php
foreach ($furniture as $furnitures) {
  ?>
						<tr>
							<td>
								<?=$furnitures->name?>
							</td>
							<td>£
								<?=$furnitures->price?>
							</td>
							<td>
								<?php if ($furnitures->archived == false) {?> No
									<?php }elseif($furnitures->archived == true){?> Yes
										<?php }
  ?>
							</td>
							<td><a style="float: right" href="/furniture/edit?id=<?=$furnitures->id?>">Edit</a></td>
							<td>
								<form method="post" action="/furniture/delete">
									<input type="hidden" name="id" value="<?=$furnitures->id?>" />
									<input type="submit" name="submit" value="Delete" /> </form>
							</td>
						</tr>
						<?php
}
?>
				</thead>
			</table>
		</section>
</main>
