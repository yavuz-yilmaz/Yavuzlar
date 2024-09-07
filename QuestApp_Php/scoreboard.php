<?php
require 'db_connect.php';

$scores = [];

$stmt = $db->prepare("SELECT * FROM users");
$stmt->execute();
$userlist = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($userlist as $user) {
  array_push($scores, [$user['username'], 0]);
}

$stmt = $db->prepare("SELECT * FROM submissions");
$stmt->execute();
$submissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($submissions as $submission) {
  if ($submission['IsCorrect'] == 1) {
    for ($i = 0; $i < count($scores); $i++) {
      if ($scores[$i][0] == $submission['username']) {

        $scores[$i][1]++;
        break;
      }
    }
  }
}
function compare_scores($a, $b)
{
  return $b[1] - $a[1];
}
usort($scores, 'compare_scores');

for ($i = count($scores) - 1; $i >= 0; $i--) {
  if ($scores[$i][1] == 0) {
    array_splice($scores, $i, 1);
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
    <button class="back-button" onclick="location.href='main.php'">Geri</button>
    <h3 class="scoreboard-header">Skor Tablosu</h3>
    <div class="scoreboard">
      <?php
      foreach ($scores as $index => $score) {
        echo "<h4 class='scoreboard-text' >" . $index + 1 . ". " . $score[0] . " : " . $score[1] . "</h4>";
      }
      ?>
    </div>
  </div>
</body>

</html>