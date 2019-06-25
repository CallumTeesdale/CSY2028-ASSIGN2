<main class="admin">

<section class="left">
  <ul>
    <?php
    require '../templates/public/categories.html.php';
    ?>
  </ul>
</section>


<section class="right">

  <h1><?=$sub = (is_object($subtitle)) ? $subtitle->name : 'Furniture' ;?></h1>
  <div class="ordered">
  <form action="" method="POST" id="order">
    <select name="order">
      <option value="NEW">NEW</option>
      <option value="SECOND HAND">SECOND HAND</option>
    </select>
    <input type="submit" value="ORDER" id="orderSubmit">
  </form>
  </div>
  <br>
  <br>
  <br>

<ul class="furniture">
<?php
require '../templates/public/furniture.html.php';
?>
</ul>
</section>
</main>
