<?php
include "db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!isset($_POST["old_password"]) || !isset($_POST["new_password"]) || !isset($_POST["new_password_confirm"])) {
    header("Location: /profile.php");
    exit();
  }

  $stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
  $stmt->bindParam(":id", $_SESSION["user"]["id"]);
  $stmt->execute();
  $user = $stmt->fetch();

  if (!password_verify($_POST["old_password"], $user["password"])) {
    header("Location: /profile.php");
    exit();
  }

  if ($_POST["new_password"] != $_POST["new_password_confirm"]) {
    header("Location: /profile.php");
    exit();
  }

  $stmt = $db->prepare("UPDATE users SET password = :password WHERE id = :id");
  $password = password_hash($_POST["new_password"], PASSWORD_ARGON2ID);
  $stmt->bindParam(":password", $password);
  $stmt->bindParam(":id", $_SESSION["user"]["id"]);
  $stmt->execute();
  header("Location: /profile.php");
}
?>