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
          <h2 class="card-title text-center mb-4">Kupon Yönetimi</h2>
          <a href="/panels/admin/admin.php" class="btn btn-secondary">Geri</a>
          <a href="/panels/admin/add-coupon.php" class="btn btn-primary">Kupon Ekle</a>
          <table class="table mt-4">
            <thead>
              <tr>
                <th scope="col">id</th>
                <th scope="col">Restorant id</th>
                <th scope="col">İsim</th>
                <th scope="col">İndirim</th>
                <th scope="col">Oluşturulma Tarihi</th>
                <th scope="col" class="text-end">İşlemler</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $stmt = $db->prepare("SELECT * FROM cupon");
              $stmt->execute();
              $coupons = $stmt->fetchAll();

              foreach ($coupons as $coupon) {
                echo "<tr>";
                echo "<th scope='row'>" . $coupon["id"] . "</th>";
                echo "<td>" . $coupon["restaurant_id"] . "</td>";
                echo "<td>" . $coupon["name"] . "</td>";
                echo "<td>" . $coupon["discount"] . "</td>";
                echo "<td>" . $coupon["created_at"] . "</td>";
                echo "<td class='text-end'>
                  <a href='/panels/admin/delete-coupon.php?id=" . $coupon["id"] . "' class='btn btn-danger'>Sil</a>
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