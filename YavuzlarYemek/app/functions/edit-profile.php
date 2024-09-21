<?php
include "db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (!isset($_POST["name"]) || !isset($_POST["surname"]) || !isset($_POST["username"])) {
    header("Location: /profile.php");
    exit();
  }

  $stmt = $db->prepare("SELECT * FROM users WHERE username = :username AND id != :id");
  $stmt->bindParam(":username", $_POST["username"]);
  $stmt->bindParam(":id", $_SESSION["user"]["id"]);
  $stmt->execute();
  $user = $stmt->fetch();
  if ($user) {
    header("Location: /profile.php");
    exit();
  } else {
    $stmt = $db->prepare("UPDATE users SET name = :name, surname = :surname, username = :username WHERE id = :id");
    $stmt->bindParam(":name", $_POST["name"]);
    $stmt->bindParam(":surname", $_POST["surname"]);
    $stmt->bindParam(":username", $_POST["username"]);
    $stmt->bindParam(":id", $_SESSION["user"]["id"]);
    $stmt->execute();
  }
  header("Location: /profile.php");
}
?>