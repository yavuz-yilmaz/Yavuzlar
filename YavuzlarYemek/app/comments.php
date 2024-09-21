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

$stmt = $db->prepare("SELECT * FROM comments WHERE restaurant_id = :restaurant_id");
$stmt->bindParam(":restaurant_id", $_GET["id"]);
$stmt->execute();
$comments = $stmt->fetchAll();

$stmt = $db->prepare("SELECT AVG(score) as avg_score FROM comments WHERE restaurant_id = :restaurant_id");
$stmt->bindParam(":restaurant_id", $_GET["id"]);
$stmt->execute();
$avgScore = $stmt->fetch()["avg_score"];

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
    <h4 class="text-center"><?php echo $restaurant["name"] ?></h4>
    <?php if (isset($avgScore)): ?>
      <h5 class="text-center">Ortalama Puan: <?php echo intval($avgScore) ?></h5>
    <?php endif; ?>
    <div class="text-center">
      <a href="/add-comment.php?id=<?php echo $restaurant["id"] ?>" class="btn btn-primary">Yorum Ekle</a>
    </div>
    <?php foreach ($comments as $comment): ?>
      <div class="col-md-6 offset-md-3">
        <div class="card mb-3">
          <div class="card-body">
            <h5 class="card-title"><?php echo $comment["title"] . " " . $comment["score"] . "/10" ?></h5>

            <h6 class="card-subtitle mb-2 text-muted"><?php echo $comment["surname"] ?></h6>
            <p class="card-text"><?php echo $comment["description"] ?></p>
            <p class="card-text"><small class="text-muted"><?php echo $comment["created_at"] ?></small></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  </div>
</body>

</html>