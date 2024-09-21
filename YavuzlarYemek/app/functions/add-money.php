<?php
include "db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!isset($_POST["amount"])) {
    header("Location: /profile.php");
    exit();
  }

  $stmt = $db->prepare("UPDATE users SET balance = balance + :amount WHERE id = :id");
  $stmt->bindParam(":amount", $_POST["amount"]);
  $stmt->bindParam(":id", $_SESSION["user"]["id"]);
  $stmt->execute();
  header("Location: /profile.php");
}
?>