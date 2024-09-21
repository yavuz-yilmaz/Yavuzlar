<?php
include "functions/db.php";

session_start();
if (isset($_SESSION["user"])) {
  header("Location: /index.php");
  return;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $surname = $_POST["surname"];
  $username = $_POST["username"];
  $password = $_POST["password"];

  if (empty($name) || empty($surname) || empty($username) || empty($password)) {
    echo "Lütfen tüm alanları doldurunuz.";
    return;
  }
  $password = password_hash($password, PASSWORD_ARGON2ID);

  $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
  $stmt->bindParam(":username", $username);
  $stmt->execute();
  $user = $stmt->fetch();
  if ($user) {
    echo "Bu kullanıcı adı zaten alınmış.";
    return;
  }
  $stmt = $db->prepare("INSERT INTO users (name, surname, username, password, role, created_at) VALUES (:name, :surname, :username, :password, 'customer', NOW())");
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":surname", $surname);
  $stmt->bindParam(":username", $username);
  $stmt->bindParam(":password", $password);
  $stmt->execute();

  $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
  $stmt->bindParam(":username", $username);
  $stmt->execute();
  $user = $stmt->fetch();
  if ($user) {
    $_SESSION["user"] = $user;
  }
  header("Location: /index.php");
  return;
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
      <div class="col-md-6">
        <div class="card">
          <div class="card-body">
            <h2 class="card-title text-center mb-4">Kayıt Formu</h2>
            <form action="register.php" method="POST">
              <div class="mb-3">
                <label for="name" class="form-label">Ad</label>
                <input type="text" name="name" id="name" class="form-control">
              </div>
              <div class="mb-3">
                <label for="surname" class="form-label">Soyad</label>
                <input type="text" name="surname" id="surname" class="form-control">
              </div>
              <div class="mb-3">
                <label for="username" class="form-label">Kullanıcı Adı</label>
                <input type="text" name="username" id="username" class="form-control">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" name="password" id="password" class="form-control">
              </div>
              <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>