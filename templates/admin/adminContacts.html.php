<main class="admin">
	<?php require 'adminLeft.html.php';?>
		<section class="right">
			<h2>Contacts</h2>
			<table>
				<thead>
					<tr>
						<th style="width: 10%">Name</th>
						<th style="width: 50%">Enquiry</th>
						<th style="width: 10%">Dealt with</th>
            <th style="width: 10%">Dealt By</th>
						<th style="width: 5%">&nbsp;</th>
						<th style="width: 5%">&nbsp;</th>
					</tr>
					<?php
foreach ($contacts as $contact) {
  ?>
						<tr>
							<td>
								<?=$contact->fname?>
							</td>
							<td>
                <?=$contact->enquiry?>
							</td>
							<td>
								<?php if ($contact->dealt == false) {?> No
                <?php }elseif($contact->dealt== true){?> Yes
                  <td>
    								<?=$contact->getAdmin()->fname?>
    							</td>
										<?php

                   }
  ?>
							</td>
              <?php if ($contact->dealt == false): ?>
              <td><a style="float: right" href="/contact?id=<?=$contact->id?>">Respond</a></td>
              <?php endif; ?>
							<td>
								<form method="post" action="/contact/delete">
									<input type="hidden" name="id" value="<?=$contact->id?>" />
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
