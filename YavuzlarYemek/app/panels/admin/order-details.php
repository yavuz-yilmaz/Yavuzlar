<?php
include "../../functions/db.php";

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
  header("Location: /login.php");
  exit();
}

if (!$_GET["userid"] != !$_GET["orderid"]) {
  header("Location: /panels/admin/admin.php");
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

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="card">
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Sipariş Detayları</h2>
          <a href="/panels/admin/show-orders.php?id=<?php echo $_GET["userid"] ?>" class="btn btn-secondary">Geri</a>

          <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">id</th>
                <th scope="col">Yemek id</th>
                <th scope="col">Miktar</th>
                <th scope="col">Ücret</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $stmt = $db->prepare("SELECT * FROM order_items WHERE order_id = :order_id");
              $stmt->bindParam(":order_id", $_GET["orderid"]);
              $stmt->execute();
              $orders = $stmt->fetchAll();

              foreach ($orders as $order) {
                echo "<tr>";
                echo "<th scope='row'>" . $order["id"] . "</th>";
                echo "<td>" . $order["food_id"] . "</td>";
                echo "<td>" . $order["quantity"] . "</td>";
                echo "<td>" . $order["price"] . "</td>";
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