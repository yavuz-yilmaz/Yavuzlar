<?php
include "db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

if (!$_SERVER["REQUEST_METHOD"] == "POST") {
  header("Location: /cart.php");
  exit();
}
if (!isset($_POST["food_id"]) || !isset($_POST["quantity"])) {
  header("Location: /cart.php");
  exit();
}

if ($_POST["quantity"] == 0 || $_POST["quantity"] < 0) {
  $stmt = $db->prepare("DELETE FROM basket WHERE user_id = :user_id AND food_id = :food_id");
  $stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
  $stmt->bindParam(":food_id", $_POST["food_id"]);
  $stmt->execute();
} else {
  $stmt = $db->prepare("UPDATE basket SET quantity = :quantity, note = :note WHERE user_id = :user_id AND food_id = :food_id");
  $stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
  $stmt->bindParam(":food_id", $_POST["food_id"]);
  $stmt->bindParam(":quantity", $_POST["quantity"]);
  $stmt->bindParam(":note", $_POST["note"]);
  $stmt->execute();
}

header("Location: /cart.php");
?>