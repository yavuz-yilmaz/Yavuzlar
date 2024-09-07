<?php
require 'db_connect.php';
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
}

$questions = $_SESSION['questions'];
$currentQuestionIndex = $_SESSION['currentQuestionIndex'];
$score = $_SESSION['score'];

if (count($questions) == 0) {
  header("Location: warning.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $selectedAnswer = $_POST['answer'];

  if ($selectedAnswer == 'true') {
    $score++;
  }

  $isCorrect = ($selectedAnswer == 'true') ? 1 : 0;
  try {
    $stmt = $db->prepare("INSERT INTO submissions (username, questionId, IsCorrect) VALUES (:username, :questionId, :IsCorrect)");
    $stmt->bindParam(":username", $_SESSION['username']);
    $stmt->bindParam(":questionId", $questions[$currentQuestionIndex]['id']);
    $stmt->bindParam(":IsCorrect", $isCorrect);
    $stmt->execute();
  } catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
  }


  $currentQuestionIndex++;
  $_SESSION['currentQuestionIndex'] = $currentQuestionIndex;
  $_SESSION['score'] = $score;

  if ($currentQuestionIndex >= count($questions)) {
    header("Location: result.php");
    exit();
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
    <div class="container inner-container">
      <h4><?php echo $questions[$currentQuestionIndex]['question'] ?></h4>
    </div>
    <form class="options-element" method="post">
      <button class="option-button" type="submit" name="answer"
        value="<?php echo ($questions[$currentQuestionIndex]['correctAnswer'] == 'A') ? 'true' : 'false' ?>"><?php echo $questions[$currentQuestionIndex]['answerA'] ?></button>
      <button class="option-button" type="submit" name="answer"
        value="<?php echo ($questions[$currentQuestionIndex]['correctAnswer'] == 'B') ? 'true' : 'false' ?>"><?php echo $questions[$currentQuestionIndex]['answerB'] ?></button>
      <button class="option-button" type="submit" name="answer"
        value="<?php echo ($questions[$currentQuestionIndex]['correctAnswer'] == 'C') ? 'true' : 'false' ?>"><?php echo $questions[$currentQuestionIndex]['answerC'] ?></button>
      <button class="option-button" type="submit" name="answer"
        value="<?php echo ($questions[$currentQuestionIndex]['correctAnswer'] == 'D') ? 'true' : 'false' ?>"><?php echo $questions[$currentQuestionIndex]['answerD'] ?></button>
    </form>
  </div>
</body>

</html>