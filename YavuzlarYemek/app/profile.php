<?php
include "functions/db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

$stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(":id", $_SESSION["user"]["id"]);
$stmt->execute();
$user = $stmt->fetch();

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
    <h4 class="text-center">Profilim</h4>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Profil Bilgileri</h5>
            <form action="/functions/edit-profile.php" method="post">
              <div class="mb-3">
                <label for="username" class="form-label">Kullanıcı Adı</label>
                <input type="text" class="form-control" id="username" name="username"
                  value="<?php echo $user["username"] ?>">
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Ad</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user["name"] ?>">
              </div>
              <div class="mb-3">
                <label for="surname" class="form-label">Soyad</label>
                <input type="text" class="form-control" id="surname" name="surname"
                  value="<?php echo $user["surname"] ?>">
              </div>
              <button type="submit" class="btn btn-primary">Kaydet</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Para Yükle</h5>
            <p>Şu anki bakiyeniz: <?php echo $user["balance"] ?> TL</p>
            <form action="/functions/add-money.php" method="post">
              <div class="mb-3">
                <label for="amount" class="form-label">Miktar</label>
                <input type="number" class="form-control" id="amount" name="amount">
              </div>
              <button type="submit" class="btn btn-primary">Yükle</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="row mt-3">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Şifre Değiştir</h5>
            <form action="/functions/change-password.php" method="post">
              <div class="mb-3">
                <label for="old_password" class="form-label">Mevcut Şifre</label>
                <input type="password" class="form-control" id="old_password" name="old_password">
              </div>
              <div class="mb-3">
                <label for="new_password" class="form-label">Yeni Şifre</label>
                <input type="password" class="form-control" id="new_password" name="new_password">
              </div>
              <div class="mb-3">
                <label for="new_password_confirm" class="form-label">Yeni Şifre Tekrar</label>
                <input type="password" class="form-control" id="new_password_confirm" name="new_password_confirm">
              </div>
              <button type="submit" class="btn btn-primary">Değiştir</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>