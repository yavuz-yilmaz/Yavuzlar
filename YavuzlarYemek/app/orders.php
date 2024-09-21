<?php
include "functions/db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

$stmt = $db->prepare("SELECT * FROM `order` WHERE user_id = :user_id");
$stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
$stmt->execute();
$orders = $stmt->fetchAll();

$cardCount = 0;
$stmt = $db->prepare("SELECT * FROM basket WHERE user_id = :user_id");
$stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
$stmt->execute();
$cartItems = $stmt->fetchAll();
foreach ($cartItems as $cartItem) {
  $cardCount += $cartItem["quantity"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
    integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">
        <img src="/img/yavuzlar.png" width="200">
      </a>
      <div class="d-flex">
        <a href="/profile.php" class="btn btn-light me-2">Profilim</a>
        <a href="/cart.php" class="btn btn-light me-2">Sepetim(<?php echo $cardCount ?>)</a>
        <a href="/orders.php" class="btn btn-light me-2">Siparişlerim</a>
        <a href="/logout.php" class="btn btn-light">Çıkış Yap</a>
      </div>
    </div>
  </nav>

  <div class="container mt-3">
    <h4 class="text-center">Siparişlerim</h4>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">id</th>
          <th scope="col">Sipariş Durumu</th>
          <th scope="col">Toplam Tutar</th>
          <th scope="col">Sipariş Tarihi</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
          <tr>
            <th scope="row"><?php echo $order["id"] ?></th>
            <td><?php echo $order["order_status"] ?></td>
            <td><?php echo $order["total_price"] ?> TL</td>
            <td><?php echo $order["created_at"] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
</body>

</html>