<?php
include "../../functions/db.php";

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "company") {
  header("Location: /login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (!isset($_GET["id"])) {
    header("Location: /panels/company/index.php");
    exit();
  }
  $stmt = $db->prepare("SELECT * FROM `order` WHERE id = :id");
  $stmt->bindParam(":id", $_GET["id"]);
  $stmt->execute();
  $order = $stmt->fetch();
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $stmt = $db->prepare("UPDATE `order` SET order_status = :order_status WHERE id = :id");
  $stmt->bindParam(":order_status", $_POST["order_status"]);
  $stmt->bindParam(":id", $_POST["orderid"]);
  $stmt->execute();
  header("Location: /panels/company/orders.php?id=" . $_SESSION["user"]["company_id"]);
  exit();
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
    </div>
    </div>
  </nav>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="card">
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Sipariş Detayları</h2>
          <a href="/panels/company/index.php" class="btn btn-secondary">Geri</a>


          <form action="/panels/company/order.php" method="POST">
            <input type="hidden" name="orderid" value="<?php echo $order["id"] ?>">
            <div class="mb-3">
              <label for="order_status" class="form-label">Durum</label>
              <select class="form-select" id="order_status" name="order_status">
                <option value="Hazırlanıyor" <?php echo $order["order_status"] == "Hazırlanıyor" ? "selected" : "" ?>>
                  Hazırlanıyor
                </option>
                <option value="Yolda" <?php echo $order["order_status"] == "Yolda" ? "selected" : "" ?>>Yolda</option>
                <option value="Teslim Edildi" <?php echo $order["order_status"] == "Teslim Edildi" ? "selected" : "" ?>>
                  Teslim Edildi
                </option>
              </select>
              <button type="submit" class="btn btn-primary mt-3">Güncelle</button>
          </form>
        </div>
        <h4 class="text-center">Yemek Listesi</h4>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">id</th>
              <th scope="col">Yemek</th>
              <th scope="col">Adet</th>
              <th scope="col">Fiyat</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $stmt = $db->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
            $stmt->bindParam(":order_id", $order["id"]);
            $stmt->execute();
            $order_foods = $stmt->fetchAll();
            foreach ($order_foods as $order_food) {
              $stmt = $db->prepare("SELECT * FROM food WHERE id = :id");
              $stmt->bindParam(":id", $order_food["food_id"]);
              $stmt->execute();
              $food = $stmt->fetch();
              echo "<tr>";
              echo "<td>" . $food["id"] . "</td>";
              echo "<td>" . $food["name"] . "</td>";
              echo "<td>" . $order_food["quantity"] . "</td>";
              echo "<td>" . $order_food["price"] . "</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
      </div>
    </div>
  </div>
</body>

</html>