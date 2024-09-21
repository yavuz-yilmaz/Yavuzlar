<?php
include "../../functions/db.php";

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
  header("Location: /login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $description = $_POST["description"];
  $logo_path = $_POST["logo_path"];

  $stmt = $db->prepare("INSERT INTO company (name, description, logo_path) VALUES (:name, :description, :logo_path)");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':description', $description);
  $stmt->bindParam(':logo_path', $logo_path);
  $stmt->execute();

  header("Location: /panels/admin/companies.php");
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
          <h2 class="card-title text-center mb-4">Firma Ekle</h2>
          <a href="/panels/admin/companies.php" class="btn btn-secondary">Geri</a>
          <div class="container mt-3">
            <form action="/panels/admin/add-company.php" method="POST">
              <div class="mb-3">
                <label for="name" class="form-label">Firma Adı</label>
                <input type="text" name="name" id="name" class="form-control">
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Firma Açıklaması</label>
                <input type="text" name="description" id="description" class="form-control">
              </div>
              <div class="mb-3">
                <label for="logo_path" class="form-label">Logo</label>
                <input type="text" name="logo_path" id="logo_path" class="form-control">
              </div>
              <button type="submit" class="btn btn-primary">Ekle</button>
            </form>
          </div>
        </div>
      </div>
    </div>

</body>

</html>