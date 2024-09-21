<?php
include "db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

$stmt = $db->prepare("SELECT * FROM basket INNER JOIN food ON basket.food_id = food.id WHERE user_id = :user_id");
$stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
$stmt->execute();
$cartItems = $stmt->fetchAll();

$totalPrice = 0;
foreach ($cartItems as $item) {
  $totalPrice += ($item["price"] - $item["discount"]) * $item["quantity"];
}

if (isset($_SESSION["coupon"])) {
  $totalPrice -= $_SESSION["coupon"]["discount"];
}

if ($totalPrice > $_SESSION["user"]["balance"]) {
  header("Location: /cart.php?error=balance");
  exit();
} else {
  $_SESSION["user"]["balance"] -= $totalPrice;
  $stmt = $db->prepare("UPDATE users SET balance = :balance WHERE id = :id");
  $stmt->bindParam(":balance", $_SESSION["user"]["balance"]);
  $stmt->bindParam(":id", $_SESSION["user"]["id"]);
  $stmt->execute();
}
$groupedCartItems = [];
foreach ($cartItems as $cartItem) {
  $stmt = $db->prepare("SELECT restaurant_id FROM food WHERE id = :id");
  $stmt->bindParam(":id", $cartItem["food_id"]);
  $stmt->execute();
  $restaurantId = $stmt->fetchColumn();

  $stmt = $db->prepare("SELECT company_id FROM restaurant WHERE id = :id");
  $stmt->bindParam(":id", $restaurantId);
  $stmt->execute();
  $companyId = $stmt->fetchColumn();

  $groupedCartItems[$companyId][] = $cartItem;
}

foreach ($groupedCartItems as $companyId => $cartItems) {
  $stmt = $db->prepare("INSERT INTO `order` (user_id, order_status, total_price, created_at) VALUES (:user_id, 'Hazırlanıyor', 0, NOW())");
  $stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
  $stmt->execute();
  $orderId = $db->lastInsertId();

  foreach ($cartItems as $cartItem) {
    $price = ($cartItem["price"] - $cartItem["discount"]) * $cartItem["quantity"];
    $stmt = $db->prepare("INSERT INTO order_items (order_id, food_id, quantity, price) VALUES (:order_id, :food_id, :quantity, :price)");
    $stmt->bindParam(":order_id", $orderId);
    $stmt->bindParam(":food_id", $cartItem["food_id"]);
    $stmt->bindParam(":quantity", $cartItem["quantity"]);
    $stmt->bindParam(":price", $price);
    $stmt->execute();
  }

  $stmt = $db->prepare("UPDATE `order` SET total_price = :total_price WHERE id = :id");
  $stmt->bindParam(":id", $orderId);
  $stmt->bindParam(":total_price", $totalPrice);
  $stmt->execute();
}

$stmt = $db->prepare("DELETE FROM basket WHERE user_id = :user_id");
$stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
$stmt->execute();

header("Location: /cart.php");
?>