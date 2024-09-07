<?php
session_start();
if (isset($_SESSION['username'])) {
  header("Location: main.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quest App</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <div class="container" id="main_container">
    <h3>Yavuzlar Soru Uygulaması</h3>
    <form class="login-register-form" action="login.php" method="post">
      <input class="main-page-input" type="text" name="username" placeholder="Username" required>
      <input class="main-page-input" type="password" name="password" placeholder="Password" required>
      <p class="login-register-text">Hesabın yok mu? <a href="register.php">Kayıt ol</a></p>
      <button class="login-register-button" type="submit">Giriş Yap</button>
    </form>
  </div>
  </div>
</body>

</html>