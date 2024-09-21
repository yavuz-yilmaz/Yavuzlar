<?php
include "../../functions/db.php";

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
  header("Location: /login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (!$_GET["id"]) {
    header("Location: /panels/admin/companies.php");
    exit();
  }
  $stmt = $db->prepare("SELECT * FROM company WHERE id = :id");
  $stmt->bindParam(":id", $_GET["id"]);
  $stmt->execute();
  $company = $stmt->fetch();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $date = date("Y-m-d H:i:s");
  $stmt = $db->prepare("UPDATE company SET deleted_at = :deleted_at WHERE id = :id");
  $stmt->bindParam(":deleted_at", $date);
  $stmt->bindParam(":id", $_POST["id"]);
  $stmt->execute();

  header("Location: /panels/admin/companies.php");
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

  <p class="mt-3"><b><?php echo $company["name"] ?></b> isimli firmayı silmek istiyor musunuz?</p>
  <form action="/panels/admin/delete-company.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $company["id"] ?>">
    <button type="submit" class="btn btn-danger">Evet</button>
    <a href="/panels/admin/companies.php" class="btn btn-secondary">Hayır</a>
  </form>
</body>

</html>