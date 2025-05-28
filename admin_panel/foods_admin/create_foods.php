<?php
require(__DIR__ . "/../../libs/App.php");
require(__DIR__ . "/../layout/header.php");
require(__DIR__ . "/../../config/config.php");
?>

<?php

$app = new App;
$app->validateSessionAdminInside();

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $meal_id = $_POST["meal_id"];
    $image = $_FILES["image"]["name"];
    $dir = "foods_images/" . basename($image);

    $query = "INSERT INTO foods (name, price, description, meal_id, image) VALUES (:name, :price, :description, :meal_id, :image)";
    $arr = [
        ":name" => $name,
        ":price" => $price,
        ":description" => $description,
        ":meal_id" => $meal_id,
        ":image" => $image,
    ];

    $path = "show_foods.php";

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $dir)) {
        $app->register(query: $query, arr: $arr, path: $path);
    } else {
        echo "<script>alert('Không thể tải lên hình ảnh.');</script>";
    }
}
?>
<div class="row center mt-100">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Tạo thực phẩm</h5>
                <form action="create_foods.php" method="POST" enctype="multipart/form-data">
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" class="form-control" name="name" placeholder="Tên thực phẩm" required>
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <input type="text" class="form-control" name="price" placeholder="Giá" required>
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <input type="file" class="form-control" name="image" placeholder="Hình ảnh" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Chi tiết</label>
                        <textarea name="description" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="form-outline mb-4 mt-4">
                        <select class="form-select form-control" name="meal_id" required>
                            <option value="" disabled selected>Choose Meal</option>
                            <option value="1">Breakfast</option>
                            <option value="2">Lunch</option>
                            <option value="3">Dinner</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Tạo thực phẩm</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php require(__DIR__ . "/../layout/footer.php"); ?>

<?php require (__DIR__ ."/../layout/footer.php"); ?>
