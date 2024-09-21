<?php
include "../../functions/db.php";

session_start();
if (!isset($_SESSION["user"]) || $_SESSION["user"]["role"] != "company") {
  header("Location: /login.php");
  exit();
}

if (!isset($_GET["id"])) {
  header("Location: /panels/company/index.php");
  exit();
}

$stmt = $db->prepare("SELECT * FROM restaurant WHERE id = :id");
$stmt->bindParam(":id", $_GET["id"]);
$stmt->execute();
$restaurant = $stmt->fetch();
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
          <h2 class="card-title text-center mb-4"><b>
              <?php echo $restaurant["name"] ?>
            </b> Yemekler</h2>
          <a href="/panels/company/index.php" class="btn btn-secondary">Geri</a>
          <a href="/panels/company/add-food.php?id=<?php echo $_GET["id"] ?>" class="btn btn-primary">Yemek Ekle</a>
          <div class="container mt-3">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">id</th>
                  <th scope="col">Resim</th>
                  <th scope="col">İsim</th>
                  <th scope="col">Ücret</th>
                  <th scope="col">İndirim</th>
                  <th scope="col" class="text-end">İşlemler</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $stmt = $db->prepare("SELECT * FROM food WHERE restaurant_id = :restaurant_id AND deleted_at IS NULL");
                $stmt->bindParam(":restaurant_id", $_GET["id"]);
                $stmt->execute();
                $foods = $stmt->fetchAll();

                foreach ($foods as $food) {
                  echo "<tr>";
                  echo "<th scope='row'>" . $food["id"] . "</th>";
                  echo "<td>";
                  echo "<img src='/img/" . $food["image_path"] . "' width='50' />";
                  echo "</td>";
                  echo "<td>" . $food["name"] . "</td>";
                  echo "<td>" . $food["price"] . "</td>";
                  echo "<td>" . $food["discount"] . "</td>";
                  echo "<td class='text-end'>
                    <a href='/panels/company/edit-food.php?restaurantid=" . $_GET["id"] . "&foodid=" . $food["id"] . "' class='btn btn-primary'>Düzenle</a>
                    <a href='/panels/company/delete-food.php?restaurantid=" . $_GET["id"] . "&foodid=" . $food["id"] . "' class='btn btn-danger'>Sil</a>
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