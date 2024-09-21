<?php
include "../../functions/db.php";

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
  header("Location: /login.php");
  exit();
}

if (!$_GET["id"]) {
  header("Location: /panels/admin/admin.php");
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
          <h2 class="card-title text-center mb-4">Siparişler</h2>
          <a href="/panels/admin/customers.php" class="btn btn-secondary">Geri</a>

          <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">id</th>
                <th scope="col">Sipariş Durumu</th>
                <th scope="col">Toplam Ücret</th>
                <th scope="col">Oluşturulma Tarihi</th>
                <th scope="col">İşlemler</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $stmt = $db->prepare("SELECT * FROM `order` WHERE user_id = :user_id");
              $stmt->bindParam(":user_id", $_GET["id"]);
              $stmt->execute();
              $orders = $stmt->fetchAll();

              foreach ($orders as $order) {
                echo "<tr>";
                echo "<th scope='row'>" . $order["id"] . "</th>";
                echo "<td>" . $order["order_status"] . "</td>";
                echo "<td>" . $order["total_price"] . "</td>";
                echo "<td>" . $order["created_at"] . "</td>";
                echo "<td>
                <a href='/panels/admin/order-details.php?userid=" . $_GET["id"] . "&orderid=" . $order["id"] . "' class='btn btn-sm btn-primary'>Detay</a>
                </td>";
                echo "</tr>";
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
</body>

</html>