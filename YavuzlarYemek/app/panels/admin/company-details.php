<?php
include "../../functions/db.php";

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "admin") {
  header("Location: /login.php");
  exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (!isset($_GET["id"])) {
    header("Location: /panels/admin/companies.php");
    exit();
  }
  $stmt = $db->prepare("SELECT * FROM company WHERE id = :id");
  $stmt->bindParam(":id", $_GET["id"]);
  $stmt->execute();
  $company = $stmt->fetch();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $id = $_POST["id"];
  $name = $_POST["name"];
  $description = $_POST["description"];
  $logo_path = $_POST["logo_path"];

  $stmt = $db->prepare("UPDATE company SET name = :name, description = :description, logo_path = :logo_path WHERE id = :id");
  $stmt->bindParam(":name", $name);
  $stmt->bindParam(":description", $description);
  $stmt->bindParam(":logo_path", $logo_path);
  $stmt->bindParam(":id", $id);
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

  <div class="container mb-5">
    <div class="row justify-content-center">
      <div class="card mt-5">
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Firma Detayları</h2>
          <a href="/panels/admin/companies.php" class="btn btn-secondary">Geri</a>

          <div class="container mt-3">
            <form action="/panels/admin/company-details.php" method="POST">
              <input type="hidden" name="id" id="id" value=<?php echo $_GET["id"] ?>>
              <div class="mb-3">
                <label for="name" class="form-label">Firma Adı</label>
                <input type="text" name="name" id="name" class="form-control" value="<?php echo $company["name"] ?>">
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Firma Açıklaması</label>
                <input type="text" name="description" id="description" class="form-control"
                  value="<?php echo $company["description"] ?>">
              </div>
              <div class="mb-3">
                <label for="logo_path" class="form-label">Logo</label>
                <input type="text" name="logo_path" id="logo_path" class="form-control"
                  value="<?php echo $company["logo_path"] ?>">
              </div>
              <button type="submit" class="btn btn-primary">Kaydet</button>
            </form>
          </div>
          <div class="container mt-3">
            <h4 class="card-title text-center mb-4">Firmanın Restoranları</h4>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">Logo</th>
                  <th scope="col">İsim</th>
                  <th scope="col">Açıklama</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $stmt = $db->prepare("SELECT * FROM restaurant WHERE company_id = :company_id");
                $stmt->bindParam(":company_id", $company["id"]);
                $stmt->execute();
                $restaurants = $stmt->fetchAll();
                foreach ($restaurants as $restaurant) {
                  echo "<tr>";
                  echo "<th scope='row'>" . $restaurant["id"] . "</th>";
                  echo "<td>";
                  echo "<img src='/img/" . $restaurant["image_path"] . "' width='50' />";
                  echo "</td>";
                  echo "<td>" . $restaurant["name"] . "</td>";
                  echo "<td>" . $restaurant["description"] . "</td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
</body>

</html>