<?php
require_once(__DIR__."/layout.php");

$sql = new mysqli("localhost", "admin", "admin4321", "portfolio");

$categories = $sql->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);
$images = $sql->query("SELECT * FROM images")->fetch_all(MYSQLI_ASSOC);

layout(function() {
  global $categories, $images;
  ?>
    <div>
      <div id="drawing-theme-list">
      <?php
        for ($i=0; $i < count($categories); $i++) { 
          $category = $categories[$i];
          ?>
            <div class="drawing-theme">
              <?= $category["name"] ?>
            </div>
          <?php
        }
        ?>
      </div>
      <div id="drawing-previews">
        <?php
        for ($i=0; $i < count($images); $i++) { 
          $image = $images[$i];
          ?>
            <div class="drawing-preview-container">
              <a href="">
                <img src="/images/<?= $image["image"] ?>" alt="">
              </a>
            </div>
          <?php
        }
        ?>
      </div>
    </div>

    <script src="./drawing.js"></script>
  <?php
});