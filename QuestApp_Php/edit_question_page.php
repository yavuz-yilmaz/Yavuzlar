<?php
require 'db_connect.php';

session_start();

if ($_SESSION['user_role'] != 'admin') {
  header("Location: main.php");
  exit();
}

$questionId = $_GET['id'];

try {
  $stmt = $db->prepare("SELECT * FROM questions WHERE id = :id");
  $stmt->bindParam(":id", $questionId);
  $stmt->execute();

  $question = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Hata: " . $e->getMessage();
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
    <h3>Soru Düzenleme Sayfası</h3>
    <form action="edit_question.php" method="post" id="soru_form">
      <input type="hidden" name="id" value="<?php echo $questionId; ?>">
      <textarea class="text-input" type="text" name="question" placeholder="Soru giriniz"
        required><?php echo $question['question'] ?></textarea>
      <input class="text-input" type="text" name="answerA" placeholder="A şıkkını giriniz" required
        value="<?php echo $question['answerA'] ?>"></input>
      <input class="text-input" type="text" name="answerB" placeholder="B şıkkını giriniz" required
        value="<?php echo $question['answerB'] ?>"></input>
      <input class="text-input" type="text" name="answerC" placeholder="C şıkkını giriniz" required
        value="<?php echo $question['answerC'] ?>"></input>
      <input class="text-input" type="text" name="answerD" placeholder="D şıkkını giriniz" required
        value="<?php echo $question['answerD'] ?>"></input>
      <label>Doğru Cevap:</label>
      <select class="text-input" name="correctAnswer" value="<?php echo $question['correctAnswer'] ?>">
        <option value="A" <?php echo ($question['correctAnswer'] == 'A') ? 'selected' : '' ?>>A</option>
        <option value="B" <?php echo ($question['correctAnswer'] == 'B') ? 'selected' : '' ?>>B</option>
        <option value="C" <?php echo ($question['correctAnswer'] == 'C') ? 'selected' : '' ?>>C</option>
        <option value="D" <?php echo ($question['correctAnswer'] == 'D') ? 'selected' : '' ?>>D</option>
      </select>
      <button class="bottom-button" type="submit">Kaydet</button>
    </form>
  </div>
</body>

</html>