<?php
require(__DIR__."/../sql.php");

$categories = $sql->query("SELECT * FROM categories")->fetch_all(MYSQLI_ASSOC);
function categoryDropdown($value = 0) {
  global $categories;
  ?>
  <select name="category" id="category">
    <option value=""></option>
    <?php
    for ($i=0; $i < count($categories); $i++) { 
      $category = $categories[$i];
      $id = $category["id"];
      $name = $category["name"];
      $selected = $value == $id ? "selected" : "";

      echo "<option $selected value=\"$id\">$name</option>";
    }
    ?>
  </select>
  <?php
}