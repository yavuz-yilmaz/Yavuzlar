<?php
require 'db_connect.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  try {
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (empty($user)) {
      echo "Kullanıcı bulunamadı!";
      exit();
    }
    if ($password == $user['password']) {
      $_SESSION['username'] = $username;
      $_SESSION['user_role'] = $user['role'];
      echo 'Giris başarılı!';

      header("Location: main.php");
    } else {
      echo "Şifre hatalı!";
    }

  } catch (PDOException $e) {
    echo "Giriş hatası: " . $e->getMessage();
  }
}
?>