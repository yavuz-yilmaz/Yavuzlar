<?php
require 'db_connect.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $query = htmlspecialchars($_POST['search_query']);
  try {
    $stmt = $db->prepare("SELECT * FROM questions WHERE question LIKE :query");
    $likeQuery = "%" . $query . "%";
    $stmt->bindParam(":query", $likeQuery);
    $stmt->execute();
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "Hata: " . $e->getMessage();
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
  <script>
    const deleteQuestion = (questionId) => {
      fetch('delete_question.php', {
        method: 'POST',
        body: new URLSearchParams({
          'id': questionId
        })
      }).then(response => response.text())
        .then(data => {
          if (data === 'Success') {
            alert('Soru silindi!');
            document.getElementById('question_' + questionId).remove();
          } else {
            alert('Soru silinirken hata oluştu!');
          }
        })
    }
  </script>
</head>

<body>
  <div class="container" id="main_container">
    <button class="back-button" onclick="location.href='admin.php'">Geri</button>
    <h3>Arama Sonuçları</h3>
    <?php
    if (count($questions) == 0) {
      echo "<h4>Sonuç Bulunamadı!</h4>";
    } ?>
    <div class="question-list" id="question_list">
      <?php
      foreach ($questions as $question) {
        $question_text = (strlen($question['question']) > 30) ? substr($question['question'], 0, 30) . "..." : $question['question'];
        echo "<div class= 'container question' id='question_" . $question['id'] . "'>" . $question_text . "<button class= 'admin-panel-question-button' onclick=\"location.href='edit_question_page.php?id=" . $question['id'] . "'\">Düzenle</button><button class= 'admin-panel-question-button' onclick='deleteQuestion(" . $question['id'] . ")'>Sil</button></div>";
      }
      ?>
    </div>
  </div>
</body>

</html>