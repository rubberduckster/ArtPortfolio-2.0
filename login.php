<?php
require_once(__DIR__."/layout.php");
require_once(__DIR__."/sql.php");

session_start();

$username = $_POST["username"];
$password = $_POST["password"];

$user = $sql->query("SELECT * FROM users WHERE username = '$username'")->fetch_assoc();

if (!$user) {
  echo "Wrong login";
}

if (password_verify($password, $user["password"])) {
  $_SESSION["userid"] = $user["id"];
  $_SESSION["username"] = $user["username"];
  $_SESSION["usertoken"] = $user["usertoken"];
  header("location: /");
}

layout(function() {
?>
  <div>
    <form method="post">
      <div>
        <label for="username">Usern</label>
        <input name="username">
      </div>
      <div>
        <label for="password">Passn</label>
        <input name="password" type="password">
      </div>
      <div>
        <input type="submit">
      </div>
    </form>
  </div>
<?php
});