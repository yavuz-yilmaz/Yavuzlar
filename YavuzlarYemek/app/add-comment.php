<?php
include "functions/db.php";

session_start();
if (!isset($_SESSION["user"])) {
  header("Location: /login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (!isset($_GET["id"])) {
    header("Location: /index.php");
    exit();
  }
  $stmt = $db->prepare("SELECT * FROM comments WHERE user_id = :user_id AND restaurant_id = :restaurant_id");
  $stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
  $stmt->bindParam(":restaurant_id", $_GET["id"]);
  $stmt->execute();
  $comment = $stmt->fetch();
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!isset($_POST["title"]) || !isset($_POST["description"]) || !isset($_POST["score"]) || !isset($_POST["restaurant_id"])) {
    header("Location: /index.php");
    exit();
  }

  if ($_POST["score"] < 1 || $_POST["score"] > 10) {
    header("Location: /comments.php?id=" . $_POST["restaurant_id"]);
    exit();
  }

  $stmt = $db->prepare("SELECT * FROM comments WHERE user_id = :user_id AND restaurant_id = :restaurant_id");
  $stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
  $stmt->bindParam(":restaurant_id", $_POST["restaurant_id"]);
  $stmt->execute();
  $comment = $stmt->fetch();

  if ($comment) {
    $stmt = $db->prepare("UPDATE comments SET title = :title, description = :description, score = :score WHERE id = :id");
    $stmt->bindParam(":title", $_POST["title"]);
    $stmt->bindParam(":description", $_POST["description"]);
    $stmt->bindParam(":score", $_POST["score"]);
    $stmt->bindParam(":id", $comment["id"]);
  } else {
    $stmt = $db->prepare("INSERT INTO comments (title, description, score, user_id, restaurant_id, surname, created_at) VALUES (:title, :description, :score, :user_id, :restaurant_id, :surname, NOW())");
    $stmt->bindParam(":title", $_POST["title"]);
    $stmt->bindParam(":description", $_POST["description"]);
    $stmt->bindParam(":score", $_POST["score"]);
    $stmt->bindParam(":user_id", $_SESSION["user"]["id"]);
    $stmt->bindParam(":restaurant_id", $_POST["restaurant_id"]);
    $stmt->bindParam(":surname", $_SESSION["user"]["surname"]);
  }
  $stmt->execute();
  header("Location: /comments.php?id=" . $_POST["restaurant_id"]);
  exit();
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
    integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Document</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">
        <img src="/img/yavuzlar.png" width="200">
      </a>
      <div class="d-flex">
        <a href="/profile.php" class="btn btn-light me-2">Profilim</a>
        <a href="/cart.php" class="btn btn-light me-2">Sepetim</a>
        <a href="/orders.php" class="btn btn-light me-2">Siparişlerim</a>
        <a href="/logout.php" class="btn btn-light">Çıkış Yap</a>
      </div>
    </div>
  </nav>
  <div class="container mt-3">
    <h4 class="text-center">Yorum Ekle</h4>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <div class="card">
          <div class="card-body">
            <?php if ($comment): ?>
              <form action="functions/delete-comment.php" method="post">
                <input type="hidden" name="id" value="<?php echo $comment["id"] ?>">
                <button type="submit" class="btn btn-danger mb-3">Yorumu Sil</button>
              </form>
            <?php endif; ?>
            <form action="/add-comment.php" method="post">
              <input type="hidden" name="restaurant_id" value="<?php echo $_GET["id"] ?>">
              <div class="mb-3">
                <label for="title" class="form-label">Başlık</label>
                <input type="text" class="form-control" id="title" name="title"
                  value="<?php echo $comment ? $comment["title"] : "" ?>">
                <div class="mb-3">
                  <label for="description" class="form-label">Yorum</label>
                  <textarea class="form-control" id="description" name="description"
                    rows="3"><?php echo $comment ? $comment["description"] : "" ?></textarea>
                </div>
                <div class="mb-3">
                  <label for="score" class="form-label">Puan</label>
                  <input type="number" class="form-control" id="score" name="score"
                    value="<?php echo $comment ? $comment["score"] : "" ?>">
                </div>
                <button type="submit" class="btn btn-primary">Gönder</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>