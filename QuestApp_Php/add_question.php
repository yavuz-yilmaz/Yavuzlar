<?php
require 'db_connect.php';
session_start();

if ($_SESSION['user_role'] != 'admin') {
  header("Location: main.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $question_text = $_POST['question'];
  $answerA = $_POST['answerA'];
  $answerB = $_POST['answerB'];
  $answerC = $_POST['answerC'];
  $answerD = $_POST['answerD'];
  $correctAnswer = $_POST['correctAnswer'];
}

try {
  $stmt = $db->prepare("INSERT INTO questions (question, answerA, answerB, answerC, answerD, correctAnswer) VALUES (:question, :answerA, :answerB, :answerC, :answerD, :correctAnswer)");
  $stmt->bindParam(':question', $question_text);
  $stmt->bindParam(':answerA', $answerA);
  $stmt->bindParam(':answerB', $answerB);
  $stmt->bindParam(':answerC', $answerC);
  $stmt->bindParam(':answerD', $answerD);
  $stmt->bindParam(':correctAnswer', $correctAnswer);
  $stmt->execute();

  header("Location: admin.php");

} catch (PDOException $e) {
  echo "Hata: " . $e->getMessage();
}

?>