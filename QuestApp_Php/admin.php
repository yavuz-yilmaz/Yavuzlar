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
    <button class="back-button" onclick="location.href='main.php'">Geri</button>
    <form action="search_results.php" id="search_form" method="post">
      <input type="text" id="search_bar" name="search_query" placeholder="Soru Ara"></input>
    </form>
    <div class="question-list" id="question_list">
      <?php
      require 'db_connect.php';
      session_start();

      if ($_SESSION['user_role'] != 'admin') {
        header("Location main.php");
        exit();
      }
      try {
        $stmt = $db->prepare("SELECT * FROM questions");
        $stmt->execute();
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($questions as $question) {
          $question_text = (strlen($question['question']) > 30) ? substr($question['question'], 0, 30) . "..." : $question['question'];
          echo "<div class= 'container question' id='question_" . $question['id'] . "'>" . $question_text . "<button class= 'admin-panel-question-button' onclick=\"location.href='edit_question_page.php?id=" . $question['id'] . "'\">Düzenle</button><button class= 'admin-panel-question-button' onclick='deleteQuestion(" . $question['id'] . ")'>Sil</button></div>";
        }
      } catch (PDOException $e) {
        echo "Hata: " . $e->getMessage();
      }
      ?>
    </div>
    <button class="bottom-button" onclick="location.href='add_question_page.php'">Soru Ekle</button>
  </div>
  </div>
  <script>
    const searchForm = document.getElementById('search_form');
    const searchBar = document.getElementById('search_bar');
    searchBar.addEventListener('keypress', (event) => {
      if (event.key === 'Enter') {
        event.preventDefault();
        searchForm.submit();
      }
    });
  </script>
</body>

</html>