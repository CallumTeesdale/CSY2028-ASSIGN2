<main class="home">
<?php if (count($errors) > 0) { ?>
        <p>Error in sending enquiry:</p>
        <ul>
            <?php foreach ($errors as $error) { ?>
                <li><?= $error ?></li>
            <?php } ?>
        </ul>
    <?php } ?>
  <?php if (!isset($_GET['id'])): ?>
			<form action="" method="post">
				<input type="hidden" name="contact[id]" value="<?=$contact->id ?? ''?>" />
							<label>First Name:</label>
							<input type="text" name="contact[fname]" value="<?=$contact->fname ?? ''?>" />
							<label>Last Name:</label>
							<input type="text" name="contact[lname]" value="<?=$contact->lname ?? ''?>"  />
							<label>Email:</label>
							<input type="email" name="contact[email]" value="<?=$contact->email ?? ''?>" />
							<label>Phone Number:</label>
							<input type="text" name="contact[contact_no]" value="<?=$contact->contact_no ?? ''?>" />
							<label>Enquiry:</label>
							<textarea name="contact[enquiry]" rows="3" cols="40" ><?=$contact->enquiry?? ''?></textarea>
              <input type="hidden" name="contact[dealt]" value="0" />

							<input type="submit" value="Send"> </form>
              <?php else: ?>
                <form action="" method="post">
          				<input type="hidden" name="contact[id]" value="<?=$contact->id ?? ''?>"/>
          							<label>First Name:</label>
          							<input type="text" name="contact[fname]" value="<?=$contact->fname ?? ''?>"  readonly />
          							<label>Last Name:</label>
          							<input type="text" name="contact[lname]" value="<?=$contact->lname ?? ''?>"  readonly />
          							<label>Email:</label>
          							<input type="email" name="contact[email]" value="<?=$contact->email ?? ''?>"  readonly/>
          							<label>Phone Number:</label>
          							<input type="text" name="contact[contact_no]" value="<?=$contact->contact_no ?? ''?>"  readonly/>
          							<label>Enquiry:</label>
          							<textarea name="contact[enquiry]" rows="3" cols="40"  readonly><?=$contact->enquiry?? ''?></textarea>
                        <input type="hidden" name="contact[dealt]" value="1" />
                        <input type="hidden" name="contact[adminId]" value="<?=$_SESSION['id']?>" />
          							<input type="submit" value="Responded"> </form>
              <?php endif; ?>
</main>
