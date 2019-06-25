<main class="admin">
	<?php require 'adminLeft.html.php';?>
		<section class="right">
			<h2>News</h2> <a class="new" href="/admin/news">Create new Article</a>
			<table>
				<thead>
					<tr>
						<th style="width: 10%">Title</th>
						<th style="width: 10%">Description</th>
						<th style="width: 10%">Date</th>
                        <th style="width: 10%">Author</th>
                        <th style="width: 5%">&nbsp;</th>
						<th style="width: 5%">&nbsp;</th>
					</tr>
					<?php
foreach ($news as $new) {
  ?>
						<tr>
							<td>
								<?=$new->title?>
							</td>
							<td>
								<?=$new->description?>
							</td>
							<td>
                                <?=$new->date?>
							</td>
                            <td>
                                <?=$new->getAuthor()->username?>
							</td>
							<td><a style="float: right" href="/admin/news?id=<?=$new->id?>">Edit</a></td>
							<td>
								<form method="post" action="/news/delete">
									<input type="hidden" name="id" value="<?=$new->id?>" />
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