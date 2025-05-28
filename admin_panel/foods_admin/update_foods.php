<?php require (__DIR__ ."/../../libs/App.php"); ?>
<?php require (__DIR__ ."/../layout/header.php"); ?>
<?php require (__DIR__ ."/../../config/config.php"); ?>

<div class="mt-100"></div>

<?php
$app = new App;

// Lấy id món ăn từ URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo "<script>window.location.href='show_foods.php'</script>";
    exit;
}

// Lấy thông tin món ăn từ database
$query = "SELECT * FROM foods WHERE id = :id";
$food = $app->selectOne($query, [':id' => $id]);
if (!$food) {
    echo "<script>alert('Không tìm thấy món ăn!');window.location.href='show_foods.php'</script>";
    exit;
}

// Xử lý cập nhật khi submit
if (isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $price = intval($_POST['price']);
    $description = trim($_POST['description']);
    $meal_id = intval($_POST['meal_id']);

    // Xử lý upload ảnh nếu có
    $image = $food->image;
    if (!empty($_FILES['image']['name'])) {
        $target_dir = __DIR__ . "/foods_images/";
        // Thêm timestamp để tránh trùng tên
        $image = time() . '_' . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir . $image)) {
            // upload thành công, $image đã là tên file mới
        } else {
            // upload thất bại, giữ nguyên ảnh cũ
            $image = $food->image;
        }
    }

    $query = "UPDATE foods SET name = :name, price = :price, description = :description, meal_id = :meal_id, image = :image WHERE id = :id";
    $arr = [
        ':name' => $name,
        ':price' => $price,
        ':description' => $description,
        ':meal_id' => $meal_id,
        ':image' => $image,
        ':id' => $id
    ];
    $app->update($query, $arr, null);

    echo "<script>alert('Cập nhật thành công!');window.location.href='show_foods.php'</script>";
    exit;
}

?>

<div class="row center mt-100">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Chỉnh sửa món ăn</h5>
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label>Tên món ăn</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($food->name); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Giá</label>
                        <input type="number" name="price" class="form-control" value="<?php echo $food->price; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Mô tả</label>
                        <textarea name="description" class="form-control" required><?php echo htmlspecialchars($food->description); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Loại bữa ăn</label>
                        <select name="meal_id" class="form-control" required>
                            <option value="1" <?php if($food->meal_id == 1) echo 'selected'; ?>>Breakfast</option>
                            <option value="2" <?php if($food->meal_id == 2) echo 'selected'; ?>>Lunch</option>
                            <option value="3" <?php if($food->meal_id == 3) echo 'selected'; ?>>Dinner</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Ảnh hiện tại</label><br>
                        <img src="../../../img/<?php echo $food->image; ?>" width="120">
                    </div>
                    <div class="mb-3">
                        <label>Đổi ảnh mới (nếu muốn)</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Cập nhật</button>
                    <a href="show_foods.php" class="btn btn-secondary">Quay lại</a>
                </form>
            </div>
        </div>
    </div>
</div>
            




<?php require (__DIR__ ."/../layout/footer.php"); ?>
