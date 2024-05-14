<?php
require_once(__DIR__."/layout.php");
require_once(__DIR__."/sql.php");
include "./components/categoryDropdown.php";
include "./components/userHandler.php";

$currentImage = $_GET["i"] ?? null;

$escapedCurrentImage = $sql->escape_string($currentImage);

$image = $sql ->query("SELECT images.*, ic.categoryId FROM images 
LEFT JOIN imageCategories ic ON ic.imageId = images.id 
WHERE images.id = '$escapedCurrentImage' LIMIT 1")->fetch_assoc();

if (!$image) {
  errorPage("Image not found");
  exit;
}

$editmode = ($_GET["edit"] ?? "0") == "1";
$changed = $_POST["changed"] ?? "-1";
$deleted = ($_GET["delete"] ?? "0") == "1";

if (($editmode || $deleted) && !verifyUser()) {
  header("Location: /login.php");
}

if ($deleted) {
  $sql ->query("DELETE FROM images WHERE id = '$escapedCurrentImage'");
  unlink(__DIR__ . "/images/" . $image["image"]);
  header("Location: /");
}

if ($editmode) {
  if ($changed == "0") {
    header("Location: ?i=$currentImage");
  }

  if ($changed == "1") {
    $title = $_POST["title"];
    $date = $_POST["date"];
    $description = $_POST["description"];
    $category = $_POST["category"];

    $sql->query("UPDATE images SET 
    title='" . $sql->escape_string($title) . "',
    date='" . $sql->escape_string($date) . "',
    description='" . $sql->escape_string($description) . "'

    WHERE id = '$escapedCurrentImage'
    ");

    $escapedCategory = $sql->escape_string($category);

    if ($image["categoryId"]) {
      $sql->query("UPDATE imageCategories SET categoryId='$escapedCategory' WHERE imageId = '$escapedCurrentImage'");
    }
    else {
      $sql->query("INSERT INTO imageCategories (imageId, categoryID) VALUES ('$escapedCurrentImage', '$escapedCategory'");
    }

    header("Location: ?i=$currentImage");
  }
}

layout(function() {
  global $image, $currentImage, $editmode;
  ?>
  <script>
    function deleteImage() {
      if (confirm("Are you wanna delete this image?"))
      location.search = "<?= "?i=$currentImage&delete=1" ?>";
    }
  </script>
  <div class= "image-display">

  <?php if (verifyUser()): ?>
    <div class= "edit-bar">
      <a href="<?= "?i=$currentImage&edit=1" ?>">
        <?= file_get_contents("./icons/edit.svg") ?>
      </a>
      <a href="#" onclick="deleteImage()">
        <?= file_get_contents("./icons/delete.svg") ?>
      </a>
    </div>
    <?php endif; ?>

    <div class="image-display-details">
      <form method="post" style="display: block">
          <span class="image-display-header">
            <?php
            if ($editmode) {
              ?>
              <input name="title" value="<?= $image["title"] ?>">
              <input name="date" type="date" value="<?= $image["date"] ?>">
              <?php
            }
            else {
              ?>
              <h2 id="image-display-title">
                <?= $image["title"] ?>
              </h2>
              <p id="image-display-date">
                <?= $image["date"] ?>
              </p>
              <?php
            }
            ?>
          </span>
          <hr>
          <p id="image-display-description">
          <?php
          if ($editmode) {
            ?>
            <textarea name="description" id="description" cols="30" rows="10"><?= $image["description"] ?></textarea>
            <?php
            categoryDropdown($image["categoryId"]);
          }
          else {
            echo $image["description"];
          }
          ?>
          </p>

          <?php
          if ($editmode) {
            ?>
            <button type="submit" name="changed" value="1">Save</button>
            <button type="submit" name="changed" value="0">Cancel</button>
            <?php
          }
          ?>
      </form>
    </div>
    <div class="image-display-image-container">
      <img id="image-display-image" src="/images/<?= $image["image"] ?>">
    </div>
    <div class="image-display-related">
      <div>
        <h2>Related links</h2>
        <hr>
        <div id="image-related-links">

        </div>
      </div>
    </div>
  </div>
  <?php
});
