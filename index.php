<?php
require_once(__DIR__."/layout.php");
require_once(__DIR__."/sql.php");

session_start();

echo $_SESSION["username"];

$currentCategory = $_GET["c"] ?? null;

$categories = $sql->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);

$imageQuery = "SELECT * FROM images";
if ($currentCategory) {
  $imageQuery .= " WHERE id in (SELECT imageId FROM imageCategories WHERE categoryId = $currentCategory)";
}
$images = $sql->query($imageQuery)->fetch_all(MYSQLI_ASSOC);

layout(function() {
  global $categories, $images;
  ?>
    <div style="width: 100%;">
      <div id="drawing-theme-list">
      <div class="drawing-theme">
        <a href="?">
        All
        </a>
      </div>
      <?php
        for ($i=0; $i < count($categories); $i++) { 
          $category = $categories[$i];
          ?>
            <div class="drawing-theme">
              <a href="?c=<?=$category["id"] ?>">
              <?= $category["name"] ?>
              </a>
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
              <a href="/image.php?i=<?=$image["id"] ?>">
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
},false);