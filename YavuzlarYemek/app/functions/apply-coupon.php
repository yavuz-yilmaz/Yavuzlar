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
if (!isset($_POST["coupon"])) {
  header("Location: /cart.php");
  exit();
}

$stmt = $db->prepare("SELECT * FROM cupon WHERE name = :code");
$stmt->bindParam(":code", $_POST["coupon"]);
$stmt->execute();
$coupon = $stmt->fetch();

if (!$coupon) {
  header("Location: /cart.php");
  exit();
}

$stmt = $db->prepare("SELECT * FROM basket WHERE user_id = :user_id");
$stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
$stmt->execute();
$cartItems = $stmt->fetchAll();

$isCouponApplied = false;

foreach ($cartItems as $cartItem) {
  $stmt = $db->prepare("SELECT * FROM food WHERE id = :id");
  $stmt->bindParam(":id", $cartItem["food_id"]);
  $stmt->execute();
  $food = $stmt->fetch();

  if ($food["restaurant_id"] == $coupon["restaurant_id"]) {
    $isCouponApplied = true;
    break;
  }
}
if ($isCouponApplied) {
  $_SESSION["coupon"] = $coupon;
} else {
  unset($_SESSION["coupon"]);
}

header("Location: /cart.php");

?>