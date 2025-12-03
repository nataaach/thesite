<?php
include "vars.php";
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <title>Головна</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <div class="block b1">
      <span class="small-box"><?= $x ?></span>
      <div><?= $text1 ?></div>
    </div>

    <div class="block b2">
      <?= $text2 ?>
    </div>

    <div class="block b3">
      <ul>
        <?php foreach ($menu as $link => $name): ?>
          <li><a href="<?= $link ?>"><?= $name ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="block b4">
      <?= $text4 ?>
    </div>

    <div class="block b6">
      <?= $text6 ?>
    </div>

    <div class="block b5">
      <?= $text5 ?>
    </div>


    <div class="block b7">
      <div><?= $text7 ?></div>
      <span class="small-box"><?= $y ?></span>
    </div>
  </div>
</body>
</html>
