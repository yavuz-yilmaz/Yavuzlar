<?php
require 'db_connect.php';
session_start();

if ($_SESSION['user_role'] != 'admin') {
  header("Location: main.php");
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $questionId = $_POST['id'];

  try {
    $stmt = $db->prepare("DELETE FROM questions WHERE id = :id");
    $stmt->bindParam(":id", $questionId);
    if ($stmt->execute()) {
      echo "Success";
    } else {
      echo "Failed";
    }

  } catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
  }
}

?>