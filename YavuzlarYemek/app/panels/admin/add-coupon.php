<?php
include "../../functions/db.php";

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
  header("Location: /login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $restaurant_id = $_POST["restaurant_id"];
  $name = $_POST["name"];
  $discount = $_POST["discount"];
  $date = date("Y-m-d H:i:s");

  $stmt = $db->prepare("INSERT INTO cupon (restaurant_id, name, discount, created_at) VALUES (:restaurant_id, :name, :discount, :created_at)");
  $stmt->bindParam(':restaurant_id', $restaurant_id);
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':discount', $discount);
  $stmt->bindParam(':created_at', $date);
  $stmt->execute();

  header("Location: /panels/admin/coupons.php");
  exit();
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
    </div>
    </div>
  </nav>

  <div class="container mb-5">
    <div class="row justify-content-center">
      <div class="card mt-5">
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Kupon Ekle</h2>
          <a href="/panels/admin/coupons.php" class="btn btn-secondary">Geri</a>
          <div class="container mt-3">
            <form action="/panels/admin/add-coupon.php" method="POST">
              <div class="mb-3">
                <label for="restaurant_id" class="form-label">Restorant id</label>
                <input type="number" name="restaurant_id" id="restaurant_id" class="form-control">
              </div>
              <div class="mb-3">
                <label for="name" class="form-label">Kupon Adı</label>
                <input type="text" name="name" id="name" class="form-control">
              </div>
              <div class="mb-3">
                <label for="discount" class="form-label">İndirim</label>
                <input type="number" name="discount" id="discount" class="form-control">
              </div>
              <button type="submit" class="btn btn-primary">Ekle</button>
            </form>
          </div>
        </div>
      </div>
    </div>

</body>

</html>