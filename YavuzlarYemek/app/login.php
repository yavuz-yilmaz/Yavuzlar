<?php
include "functions/db.php";

session_start();

if (isset($_SESSION["user"])) {
  header("Location: /index.php");
  exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST["username"];
  $password = $_POST["password"];

  $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
  $stmt->bindParam(":username", $username);
  $stmt->execute();
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user["password"])) {
    $_SESSION["user"] = $user;
    if ($user["role"] == "admin") {
      header("Location: /panels/admin/admin.php");
      exit();
    } else if ($user["role"] == "company") {
      header("Location: /panels/company/index.php");
      exit();
    }
    header("Location: /index.php");
    exit();
  } else {
    echo "Kullanıcı adı veya şifre hatalı";
  }
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
            <h2 class="card-title text-center mb-4">Giriş Formu</h2>
            <form action="login.php" method="POST">
              <div class="mb-3">
                <label for="username" class="form-label">Kullanıcı Adı</label>
                <input type="text" name="username" id="username" class="form-control">
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Şifre</label>
                <input type="password" name="password" id="password" class="form-control">
              </div>
              <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
            <a href="/register.php" class="btn btn-link w-100 mt-3">Hesabınız yok mu? Kayıt olun</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>