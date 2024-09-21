<?php
include "functions/db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

if (!isset($_GET["id"])) {
  header("Location: /index.php");
  exit();
}

$stmt = $db->prepare("SELECT * FROM restaurant WHERE id = :id");
$stmt->bindParam(":id", $_GET["id"]);
$stmt->execute();
$restaurant = $stmt->fetch();

$stmt = $db->prepare("SELECT * FROM food WHERE restaurant_id = :restaurant_id");
$stmt->bindParam(":restaurant_id", $_GET["id"]);
$stmt->execute();
$foods = $stmt->fetchAll();

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
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
    integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    </div>
  </nav>
  <div class="container mt-3">
    <h4 class="text-center"><?php echo $restaurant["name"] ?></h4>
    <div class="row">
      <?php foreach ($foods as $food): ?>
        <div class="col-md-2 mb-4">
          <div class="card" style="width: 100%;">
            <img class="card-img-top" src="/img/<?php echo $food['image_path']; ?>" alt="">
            <div class="card-body">
              <h5 class="card-title text-center"><?php echo $food['name']; ?></h5>
              <div class="d-flex align-items-center">
                <p class="card-text text-decoration-line-through me-2"><?php echo $food['price']; ?> TL</p>
                <p class="card-text"><?php echo $food['price'] - $food["discount"]; ?> TL</p>
              </div>
              <a href="/functions/add-to-cart.php?restaurantid=<?php echo $restaurant['id']; ?>&foodid=<?php echo $food["id"] ?>"
                class="btn btn-primary">Sepete Ekle</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>