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

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $restaurant_id = $_POST["restaurant_id"];
  $food_id = $_POST["food_id"];
  $name = $_POST["name"];
  $description = $_POST["description"];
  $price = $_POST["price"];
  $discount = $_POST["discount"];
  $image_path = $_POST["image_path"];

  $stmt = $db->prepare("UPDATE food SET name = :name, description = :description, price = :price, discount = :discount, image_path = :image_path WHERE id = :id");
  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':description', $description);
  $stmt->bindParam(':price', $price);
  $stmt->bindParam(':discount', $discount);
  $stmt->bindParam(':image_path', $image_path);
  $stmt->bindParam(':id', $food_id);
  $stmt->execute();

  header("Location: /panels/company/foods.php?id=" . $restaurant_id);
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
          <h2 class="card-title text-center mb-4">Yemek Düzenle</h2>
          <a href="/panels/company/foods.php?id=<?php echo $_GET["restaurantid"] ?>" class="btn btn-secondary">Geri</a>
          <div class="container mt-3">
            <form action="/panels/company/edit-food.php" method="POST">

              <input type="hidden" name="restaurant_id" id="restaurant_id" value="<?php echo $_GET["restaurantid"] ?>">
              <input type="hidden" name="food_id" id="food_id" value="<?php echo $_GET["foodid"] ?>">
              <div class="mb-3">
                <label for="name" class="form-label">İsim</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $food["name"] ?>">
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Açıklama</label>
                <input type="text" class="form-control" id="description" name="description"
                  value="<?php echo $food["description"] ?>">
              </div>
              <div class="mb-3">
                <label for="price" class="form-label">Ücret</label>
                <input type="text" class="form-control" id="price" name="price" value="<?php echo $food["price"] ?>">
              </div>
              <div class="mb-3">
                <label for="discount" class="form-label">İndirim</label>
                <input type="text" class="form-control" id="discount" name="discount"
                  value="<?php echo $food["discount"] ?>">
              </div>
              <div class="mb-3">
                <label for="image_path" class="form-label">Resim</label>
                <input type="text" class="form-control" id="image_path" name="image_path"
                  value="<?php echo $food["image_path"] ?>">
              </div>
              <button type="submit" class="btn btn-primary">Kaydet</button>
            </form>
          </div>
        </div>
      </div>
</body>

</html>