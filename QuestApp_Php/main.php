<?php
require 'db_connect.php';

session_start();

$stmt = $db->prepare("SELECT * FROM questions");
$stmt->execute();
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $db->prepare("SELECT * FROM submissions WHERE username = :username");
$stmt->bindParam(":username", $_SESSION['username']);
$stmt->execute();
$submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

for ($i = count($questions) - 1; $i >= 0; $i--) {
  $question = $questions[$i];
  foreach ($submissions as $submission) {
    if ($question['id'] == $submission['questionId']) {
      array_splice($questions, $i, 1);
    }
  }
}

shuffle($questions);

$_SESSION['questions'] = $questions;
$_SESSION['currentQuestionIndex'] = 0;
$_SESSION['score'] = 0;

foreach ($submissions as $submission) {
  if ($submission['IsCorrect'] == 1 && $submission['username'] == $_SESSION['username']) {
    $_SESSION['score']++;
  }
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
    <button class="logout-button" onclick="location.href='logout.php'">Çıkış Yap</button>
    <?php
    echo "<h4 class= 'score-text'>Skor: " . $_SESSION['score'] . "</h4>";
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
      ?>
      <div class="container inner-container" id="admin_panel" onclick="location.href='admin.php'">
        <h3>Yavuzlar Soru Uygulaması Yönetim Paneli</h3>
      </div>
      <?php
    } ?>

    <div class="container inner-container" id="list_questions" onclick="location.href='list_questions.php'">
      <h3>Soruları Listele</h3>
    </div>
    <div class="container inner-container" id="scoreboard" onclick="location.href='scoreboard.php'">
      <h3>Scoreboard</h3>
    </div>
  </div>
</body>

</html>