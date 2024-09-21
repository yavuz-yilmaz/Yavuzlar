<?php
include "db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!isset($_POST["id"])) {
    header("Location: /index.php");
    exit();
  }
  $stmt = $db->prepare("SELECT * FROM comments WHERE user_id = :user_id AND id = :id");
  $stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
  $stmt->bindParam(":id", $_POST["id"]);
  $stmt->execute();
  $comment = $stmt->fetch();
  if ($comment) {
    $stmt = $db->prepare("DELETE FROM comments WHERE id = :id");
    $stmt->bindParam(":id", $_POST["id"]);
    $stmt->execute();
  }
  header("Location: /index.php");
  exit();
}
?>