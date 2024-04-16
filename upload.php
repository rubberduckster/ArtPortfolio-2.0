<?php
require_once(__DIR__."/layout.php");
require_once(__DIR__."/sql.php");
include "./components/categoryDropdown.php";
include "./components/userHandler.php";

if (!verifyUser()) {
  header("Location: /login.php");
}


$title = $_POST["title"] ?? null;
$date = $_POST["date"] ?? null;
$description = $_POST["description"] ?? null;
$category = $_POST["category"] ?? "";
$image = $_FILES["image"] ?? null;

if($title && $date && $image) {
  $path =realpath(__DIR__ . "/images");
  $randomName = rand(0,100000);
  $typeParts = explode("/", $image["type"]);
  $ext = $typeParts[1];
  $type = $typeParts[0];

  if ($type !== "image") {
    echo "Not an image";
    exit;
  }

  $escapedExt = $sql->escape_string($ext);
  
  while (file_exists($path . "/" . $randomName . "." . $ext)) {
    $randomName = rand(0, 100000);
  }
  move_uploaded_file($image["tmp_name"], $path . "/" . $randomName . "." . $ext);
  $sql->query("INSERT INTo images (title, `date`, `description`, `image`, position ) VALUES (
    '" . $sql->escape_string($title) . "',
    '" . $sql->escape_string($date) . "',
    '" . $sql->escape_string($description) . "',
    '$randomName.$escapedExt',
    '0 0'
    )");

    $escapedCategory = $sql->escape_string($category);

    if (!empty ($category)) {
      $newId = $sql->query("SELECT id FROM images ORDER BY id DESC LIMIT 1")->fetch_assoc()["id"];
      $sql->query("INSERT INTO imageCategories(imageId, categoryId) VALUES (
        $newId,
        '$escapedCategory'
      )");
    }
}

layout(function() {
  ?>
  <div>
    <form method="post" enctype="multipart/form-data">
      <div>
        <label for="title">Title</label>
        <input type="text" name="title" required>
      </div>
      <div>
        <label for="date">Date</label>
        <input type="date" name="date" required>
      </div>
      <div>
        <label for="description">Description</label>
        <textarea name="description"></textarea>
      </div>
      <label for="category">Category</label>
        <?php categoryDropdown() ?>
      <div>
        <label for="image">Image</label>
        <input type="file" name="image" accept="image/*" required>
      </div>
      <div>
        <input type="submit">
      </div>
    </form>
  </div>
  <?php
});