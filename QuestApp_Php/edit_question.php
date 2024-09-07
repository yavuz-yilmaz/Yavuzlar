<?php
require 'db_connect.php';

session_start();

if ($_SESSION['user_role'] != 'admin') {
  header("Location: main.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $questionId = $_POST['id'];
  $questionText = $_POST['question'];
  $answerA = $_POST['answerA'];
  $answerB = $_POST['answerB'];
  $answerC = $_POST['answerC'];
  $answerD = $_POST['answerD'];
  $correctAnswer = $_POST['correctAnswer'];

  try {
    $stmt = $db->prepare("UPDATE questions SET question = :question, answerA = :answerA, answerB = :answerB, answerC = :answerC, answerD = :answerD, correctAnswer = :correctAnswer WHERE id = :id");
    $stmt->bindParam(':question', $questionText);
    $stmt->bindParam(':answerA', $answerA);
    $stmt->bindParam(':answerB', $answerB);
    $stmt->bindParam(':answerC', $answerC);
    $stmt->bindParam(':answerD', $answerD);
    $stmt->bindParam(':correctAnswer', $correctAnswer);
    $stmt->bindParam(':id', $questionId);
    $stmt->execute();

    header("Location: admin.php");
    exit();
  } catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
  }
}
?>