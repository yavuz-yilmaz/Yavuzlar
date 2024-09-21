<?php
include "../../functions/db.php";

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "company") {
  header("Location: /login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (!isset($_GET["foodid"]) || !isset($_GET["restaurantid"])) {
    header("Location: /panels/company/index.php");
    exit();
  }
  $stmt = $db->prepare("SELECT * FROM food WHERE id = :id");
  $stmt->bindParam(":id", $_GET["foodid"]);
  $stmt->execute();
  $food = $stmt->fetch();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $stmt = $db->prepare("UPDATE food SET deleted_at = NOW() WHERE id = :id");
  $stmt->bindParam(":id", $_POST["foodid"]);
  $stmt->execute();

  header("Location: /panels/company/foods.php?id=" . $_POST["restaurantid"]);
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
    </div>
    </div>
  </nav>

  <p class="mt-3"><b><?php echo $food["name"] ?></b> isimli yemeği silmek istiyor musunuz?</p>
  <form action="/panels/company/delete-food.php" method="POST">
    <input type="hidden" name="foodid" value="<?php echo $food["id"] ?>">
    <input type="hidden" name="restaurantid" value="<?php echo $_GET["restaurantid"] ?>">
    <button type="submit" class="btn btn-danger">Evet</button>
    <a href="/panels/company/foods.php?id=<?php echo $_GET["restaurantid"] ?>" class="btn btn-secondary">Hayır</a>
  </form>
</body>

</html>