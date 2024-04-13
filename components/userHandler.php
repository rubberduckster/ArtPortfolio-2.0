<?php
require(__DIR__."/../sql.php");

session_start();

function verifyUser() {
  global $sql;

if (!isset($_SESSION["usertoken"])) {
  return false;
}

  $usertoken = $_SESSION["usertoken"];

  $user = $sql->query("SELECT id FROM users WHERE usertoken='$usertoken'")->fetch_assoc();

  if ($user) {
    return true;
  }
  return false;
}
?>