<?php

if (!isset($_SESSION['loggedin']))
  {
    foreach ($categories as $category)
      { ?>
    <li><a href="/furniture/list?id=<?=$category->id
?>"><?=$category->name
?></a></li>
  <?php
      }
  }
elseif (isset($_SESSION['loggedin']))
  {

    foreach ($categories as $category)
      { ?>
    <li><a href="/furniture/list?id=<?=$category->id
?>"><?=$category->name
?></a> <a href="/category/edit?id=<?=$category->id
?>"><?='Edit'
?></a></li>
      </br>
  <?php
      }
  }
