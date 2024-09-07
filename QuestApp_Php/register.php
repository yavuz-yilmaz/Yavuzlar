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
      <h3>Kayıt Ol</h3>
        <form class ="login-register-form" action="register_submit.php" method="post">
        <input class="main-page-input" type="text" name="username" placeholder="Username" required>
        <input class="main-page-input" type="email" name="email" placeholder="Email" required>
        <input class="main-page-input" type="password" name="password" placeholder="Password" required>
        <input class="main-page-input" type="password" name="confirm_password" placeholder="Confirm Password" required>
        <p class="login-register-text">Hesabın var mı? <a href="/">Giriş Yap</a></p>
        <button class="login-register-button" type="submit">Kayıt Ol</button>
        </form>
      </div>
    </div>
  </body>
</html>
