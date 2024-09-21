<?php
include "../../functions/db.php";

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
  header("Location: /login.php");
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
          <h2 class="card-title text-center mb-4">Müşteri Yönetimi</h2>
          <a href="/panels/admin/admin.php" class="btn btn-secondary">Geri</a>

          <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">id</th>
                <th scope="col">Ad</th>
                <th scope="col">Ad</th>
                <th scope="col">Kullanıcı Adı</th>
                <th scope="col">Bakiye</th>
                <th scope="col">İşlemler</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $stmt = $db->prepare("SELECT * FROM users WHERE role = 'customer' AND deleted_at IS NULL");
              $stmt->execute();
              $customers = $stmt->fetchAll();

              foreach ($customers as $customer) {
                echo "<tr>";
                echo "<th scope='row'>" . $customer["id"] . "</th>";
                echo "<td>" . $customer["name"] . "</td>";
                echo "<td>" . $customer["surname"] . "</td>";
                echo "<td>" . $customer["username"] . "</td>";
                echo "<td>" . $customer["balance"] . "</td>";
                echo "<td>
                <a href='/panels/admin/show-orders.php?id=" . $customer["id"] . "' class='btn btn-sm btn-primary'>Siparişler</a>
                <a href='/panels/admin/delete-customer.php?id=" . $customer["id"] . "' class='btn btn-sm btn-danger'>Hesabı sil</a>
                      </td>";
                echo "</tr>";
              }
              ?>
            </tbody>
        </div>
      </div>
</body>

</html>