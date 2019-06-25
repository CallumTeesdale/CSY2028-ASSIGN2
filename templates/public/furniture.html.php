<?php


    foreach ($furniture as $furnitures)
      {

        if ($furnitures->archived == false) {?>


        <li>
        <div class="images">
          <?php
        for ($i=1; $i <5 ; $i++) {
        if (file_exists("../public/images/furniture/{$furnitures->id}_$i.jpg"))
          {
            $filename = "../public/images/furniture/{$furnitures->id}_$i.jpg";
            $handle = fopen($filename, "rb");
            $contents = fread($handle, filesize($filename));
            fclose($handle);
            echo '<img src="data:image/jpeg;base64,' . base64_encode($contents) . '"/>';
          }
        }
          ?>
        </div>
        <div class="details">
        <h2><?=$furnitures->name?></h2>
        <h3><?=$furnitures->getCategory()->name?></h3>
        <h3><?=$furnitures->cond?></h3>
        <h4>£<?=$furnitures->price?></h4>
        <p><?=$furnitures->description?></p>
        </div>
        </li>
        <?php
      }
    }

