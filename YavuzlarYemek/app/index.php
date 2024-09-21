<?php
include "functions/db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

$stmt = $db->prepare("SELECT * FROM restaurant");
$stmt->execute();
$restaurants = $stmt->fetchAll();

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
    <div class="row">
      <?php foreach ($restaurants as $restaurant): ?>
        <div class="col-md-2 mb-4">
          <div class="card" style="width: 100%;">
            <img class="card-img-top" src="/img/<?php echo $restaurant['image_path']; ?>" alt="">
            <div class="card-body">
              <h5 class="card-title text-center"><?php echo $restaurant['name']; ?></h5>
              <p class="card-text text-center"><?php echo $restaurant['description']; ?></p>
              <a href="/restaurant.php?id=<?php echo $restaurant['id']; ?>" class="btn btn-sm btn-primary">Yemekler</a>
              <a href="/comments.php?id=<?php echo $restaurant['id']; ?>" class="btn btn-sm btn-info">Yorumlar</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>