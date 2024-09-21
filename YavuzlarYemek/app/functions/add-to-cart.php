<?php
include "db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

if (!isset($_GET["restaurantid"]) || !isset($_GET["foodid"])) {
  header("Location: /index.php");
  exit();
}

$stmt = $db->prepare("SELECT * FROM basket WHERE user_id = :user_id AND food_id = :food_id");
$stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
$stmt->bindParam(":food_id", $_GET["foodid"]);
$stmt->execute();
$cartItem = $stmt->fetch();
if (!$cartItem) {

  $date = date("Y-m-d H:i:s");
  $stmt = $db->prepare("INSERT INTO basket (user_id, food_id, quantity, created_at) VALUES (:user_id, :food_id, 1, :created_at)");
  $stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
  $stmt->bindParam(":food_id", $_GET["foodid"]);
  $stmt->bindParam(":created_at", $date);
  $stmt->execute();
} else {
  $stmt = $db->prepare("UPDATE basket SET quantity = quantity + 1 WHERE user_id = :user_id AND food_id = :food_id");
  $stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
  $stmt->bindParam(":food_id", $_GET["foodid"]);
  $stmt->execute();
}

header("Location: /restaurant.php?id=" . $_GET["restaurantid"]);


?>