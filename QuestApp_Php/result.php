<?php
session_start();
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
    <button class="back-button" onclick="location.href='main.php'">Geri</button>
    <div>
      <h3><?php echo count($_SESSION['questions']) ?> sorudan <?php echo $_SESSION['score'] ?> tanesini doğru
        cevapladınız.</h3>
      <h4>Skorunuz: <?php echo $_SESSION['score'] ?></h4>
    </div>
  </div>
</body>

</html>