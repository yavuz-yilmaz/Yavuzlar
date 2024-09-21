<?php
include "functions/db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

$stmt = $db->prepare("SELECT * FROM basket WHERE user_id = :user_id");
$stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
$stmt->execute();
$cartItems = $stmt->fetchAll();

$totalPrice = 0;
$cardCount = 0;
foreach ($cartItems as $cartItem) {
  $stmt = $db->prepare("SELECT * FROM food WHERE id = :id");
  $stmt->bindParam(":id", $cartItem["food_id"]);
  $stmt->execute();
  $food = $stmt->fetch();
  $totalPrice += ($food["price"] - $food["discount"]) * $cartItem["quantity"];
  $cardCount += $cartItem["quantity"];
}

if (isset($_SESSION["coupon"])) {
  $coupon = $_SESSION["coupon"];
  $totalPrice = $totalPrice - $coupon["discount"];
}

if ($totalPrice < 0) {
  $totalPrice = 0;
  unset($_SESSION["coupon"]);
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
    <h4 class="text-center">Sepetim</h4>
    <div class="row">
      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Ürün</th>
              <th scope="col">Fiyat</th>
              <th scope="col">Adet</th>
              <th scope="col">Toplam</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($cartItems as $cartItem): ?>
              <?php
              $stmt = $db->prepare("SELECT * FROM food WHERE id = :id");
              $stmt->bindParam(":id", $cartItem["food_id"]);
              $stmt->execute();
              $food = $stmt->fetch();
              ?>
              <tr>
                <td><?php echo $food["name"]; ?></td>
                <td><?php echo $food["price"] - $food["discount"]; ?> TL</td>
                <td>
                  <form action="/functions/update-cart.php" method="POST">
                    <input type="hidden" name="food_id" value="<?php echo $food["id"]; ?>">
                    <input type="number" name="quantity" value="<?php echo $cartItem["quantity"]; ?>">
                    <input type="text" class="w-50" name="note" placeholder="Not"
                      value="<?php echo $cartItem["note"]; ?>">
                    <button type="submit" class="btn btn-primary">Güncelle</button>
                  </form>
                </td>
                <td><?php echo ($food["price"] - $food["discount"]) * $cartItem["quantity"]; ?> TL</td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php if (!isset($_SESSION["coupon"])): ?>
          <form action="/functions/apply-coupon.php" method="POST">
            <div class="input-group mb-3">
              <input type="text" class="form-control" name="coupon" placeholder="Kupon Kodu">
              <button class="btn btn-outline-success" type="submit">Kupon Kullan</button>
            </div>
          </form>
        <?php else: ?>
          <div class="alert alert-success" role="alert">
            Kupon uygulandı.
          </div>
        <?php endif; ?>
        <h5 class="text-end">Toplam: <?php echo $totalPrice; ?> TL</h5>
        <div class="d-flex justify-content-end">
          <a href="/functions/order.php" class="btn btn-primary">Siparişi Tamamla</a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>