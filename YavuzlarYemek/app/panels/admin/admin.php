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
          <h2 class="card-title text-center mb-4">Admin Panel</h2>
          <!-- Müşteri yönetimi -->
          <div class="mb-3">
            <a href="/panels/admin/customers.php" class="btn btn-primary w-100">Müşteri Yönetimi</a>
          </div>
          <!-- Firma yönetimi -->
          <div class="mb-3">
            <a href="/panels/admin/companies.php" class="btn btn-primary w-100">Firma Yönetimi</a>
          </div>
          <!-- Kupon yönetimi -->
          <div class="mb-3">
            <a href="/panels/admin/coupons.php" class="btn btn-primary w-100">Kupon Yönetimi</a>
          </div>
        </div>



</body>

</html>