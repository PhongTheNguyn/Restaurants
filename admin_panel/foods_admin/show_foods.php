<?php require (__DIR__ ."/../../libs/App.php"); ?>
<?php require (__DIR__ ."/../layout/header.php"); ?>
<?php require (__DIR__ ."/../../config/config.php"); ?>
<div class="mt-100"></div>
<?php
    $app = new App;
    $app->validateSessionAdminInside();

    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    if ($search !== '') {
        $query = "SELECT * FROM foods WHERE name LIKE :search";
        $foods = $app->selectAll($query, [':search' => '%' . $search . '%']);
    } else {
        $query = "SELECT * FROM foods";
        $foods = $app->selectAll($query);
    }
?>



<div class="row center mt-100">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4 d-inline mt-5  ">Thực phẩm</h5>
            <a href="create_foods.php" class="btn btn-primary mb-4 text-center float-end">Create foods</a>
            <form method="GET" action="show_foods.php" class="mb-3">
                <div class="input-group" style="max-width:400px;">
                    <input type="text" class="form-control" name="search" placeholder="Tìm kiếm theo tên..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                </div>
            </form>
            <div class="table">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên thực phẩm</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($foods) && count($foods) > 0): ?>
                            <?php foreach ($foods as $food): ?>
                                <tr>
                                    <td><?php echo $food->id; ?></td>
                                    <td><?php echo $food->name; ?></td>
                                    <td><img src="foods_images/<?php echo $food->image; ?>" alt="" width="100px"></td>
                                    <td><?php echo number_format($food->price); ?> VNĐ</td>
                                    <td>
                                        <a href="update_foods.php?id=<?php echo $food->id;?>" class="btn btn-primary">Cập nhật</a>
                                        <a href="delete_foods.php?id=<?php echo $food->id;?>" class="btn btn-danger text-center">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Không có thực phẩm nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
    </div>
</div>











<?php require (__DIR__ ."/../layout/footer.php"); ?>
