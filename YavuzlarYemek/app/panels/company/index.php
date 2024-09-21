<?php
include "../../functions/db.php";

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "company") {
  header("Location: /login.php");
  exit();
}

$stmt = $db->prepare("SELECT * FROM company WHERE id = :id");
$stmt->bindParam(":id", $_SESSION["user"]["company_id"]);
$stmt->execute();
$company = $stmt->fetch();
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
          <h2 class="card-title text-center mb-4">Firma Panel</h2>
          <a href="/panels/company/add-restaurant.php" class="btn btn-primary">Restaurant Ekle</a>
          <a href="/panels/company/orders.php?id=<?php echo $_SESSION["user"]["company_id"] ?>"
            class="btn btn-warning">Siparişler</a>
          <div class="container mt-3">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">Logo</th>
                  <th scope="col">İsim</th>
                  <th scope="col">Açıklama</th>
                  <th scope="col" class="text-end">İşlemler</th>
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
                  echo "<td class='text-end'>
                    <a href='/panels/company/foods.php?id=" . $restaurant["id"] . "' class='btn btn-primary'>Yemekler</a>
                    <a href='/panels/company/delete-restaurant.php?id=" . $restaurant["id"] . "' class='btn btn-danger'>Sil</a>
                  </td>";
                  echo "</tr>";
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
</body>

</html>