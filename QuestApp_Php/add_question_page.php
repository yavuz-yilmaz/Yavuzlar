<?php
session_start();
if ($_SESSION['user_role'] != 'admin') {
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
    <button class="back-button" onclick="location.href='admin.php'">Geri</button>
    <h3>Soru Ekleme Sayfası</h3>
    <form action="add_question.php" method="post" id="soru_form">
      <textarea class="text-input" type="text" name="question" placeholder="Soru giriniz" required></textarea>
      <input class="text-input" type="text" name="answerA" placeholder="A şıkkını giriniz" required></input>
      <input class="text-input" type="text" name="answerB" placeholder="B şıkkını giriniz" required></input>
      <input class="text-input" type="text" name="answerC" placeholder="C şıkkını giriniz" required></input>
      <input class="text-input" type="text" name="answerD" placeholder="D şıkkını giriniz" required></input>
      <label>Doğru Cevap:</label>
      <select class="text-input" name="correctAnswer">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
      </select>
      <button class="bottom-button" type="submit">Ekle</button>
    </form>
  </div>
</body>

</html>