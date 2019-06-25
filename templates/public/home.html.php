
	<main class="home">
		<p>Welcome to Fran's Furniture. We're a family run furniture shop based in Northampton. We stock a wide variety of modern and antique furniture including laps, bookcases, beds and sofas.</p>
		<h1>News</h1>
		<?php foreach ($news as $n): ?>
		<div class="news">
		<h2><?=$n->title?></h2>	
		<div class="images">
          <?php
        for ($i=1; $i <5 ; $i++) {
        if (file_exists("../public/images/news/{$n->id}_$i.jpg"))
          {
            $filename = "../public/images/news/{$n->id}_$i.jpg";
            $handle = fopen($filename, "rb");
            $contents = fread($handle, filesize($filename));
            fclose($handle);
            echo '<img src="data:image/jpeg;base64,' . base64_encode($contents) . '" width="200" height="200"/>';
          }
        }
          ?>
        </div>	
		<p><?=$n->description?></p>
		<h3><?=$n->date?></h3>
		</div>
		<?php endforeach; ?>
	
	</main>
