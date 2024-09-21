<?php
include "../../functions/db.php";

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "company") {
  header("Location: /login.php");
  exit();
}

if (!isset($_GET["id"])) {
  header("Location: /panels/company/index.php");
  exit();
}

$stmt = $db->prepare("SELECT * FROM restaurant WHERE company_id = :company_id");
$stmt->bindParam(":company_id", $_GET["id"]);
$stmt->execute();
$restaurants = $stmt->fetchAll();

$foods = [];
foreach ($restaurants as $restaurant) {
  $stmt = $db->prepare("SELECT * FROM food WHERE restaurant_id = :restaurant_id");
  $stmt->bindParam(":restaurant_id", $restaurant["id"]);
  $stmt->execute();
  $foods = array_merge($foods, $stmt->fetchAll());
}

$order_items = [];
foreach ($foods as $food) {
  $stmt = $db->prepare("SELECT * FROM order_items WHERE food_id = :food_id");
  $stmt->bindParam(":food_id", $food["id"]);
  $stmt->execute();
  $order_items = array_merge($order_items, $stmt->fetchAll());
}

$orders = [];
foreach ($order_items as $order_item) {
  $stmt = $db->prepare("SELECT * FROM `order` WHERE id = :order_id");
  $stmt->bindParam(":order_id", $order_item["order_id"]);
  $stmt->execute();
  $orders = array_merge($orders, $stmt->fetchAll());
}
$orders = array_reduce($orders, function ($carry, $item) {
  if (!isset($carry[$item['id']])) {
    $carry[$item['id']] = $item;
  }
  return $carry;
}, []);
$orders = array_values($orders);

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
          <h2 class="card-title text-center mb-4">Siparişler</h2>
          <a href="/panels/company/index.php" class="btn btn-secondary">Geri</a>

          <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">id</th>
                <th scope="col">Kullanıcı id</th>
                <th scope="col">Sipariş Durumu</th>
                <th scope="col">Toplam Ücret</th>
                <th scope="col">Oluşturulma Tarihi</th>
                <th scope="col">İşlemler</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($orders as $order): ?>
                <tr>
                  <th scope="row"><?php echo $order["id"] ?></th>
                  <td><?php echo $order["user_id"] ?></td>
                  <td><?php echo $order["order_status"] ?></td>
                  <td><?php echo $order["total_price"] ?></td>
                  <td><?php echo $order["created_at"] ?></td>
                  <td>
                    <a href="/panels/company/order.php?id=<?php echo $order["id"] ?>" class="btn btn-primary">Detay</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</body>

</html>