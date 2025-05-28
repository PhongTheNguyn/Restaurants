<?php require (__DIR__ ."/../../libs/App.php"); ?>
<?php require (__DIR__ ."/../layout/header.php"); ?>
<?php require (__DIR__ ."/../../config/config.php"); ?>

<?php
$app = new App;
$app->validateSessionAdminInside();

$search_phone = isset($_GET['search_phone']) ? trim($_GET['search_phone']) : '';
if ($search_phone !== '') {
    $query = "SELECT * FROM orders WHERE phone_number LIKE :phone";
    $orders = $app->selectAll($query, [':phone' => '%' . $search_phone . '%']);
} else {
    $query = "SELECT * FROM orders";
    $orders = $app->selectAll($query);
}


?>


<div class="row center mt-100">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4 d-inline m-4 ">Orders</h4>
                <form method="GET" action="orders_admin.php" class="mb-3">
                    <div class="input-group" style="max-width:400px;">
                        <input type="text" class="form-control" name="search_phone" placeholder="Tìm theo số điện thoại..." value="<?php echo isset($_GET['search_phone']) ? htmlspecialchars($_GET['search_phone']) : ''; ?>">
                        <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                    </div>
                </form>
                <div class="table">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Họ tên</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Chi tiết</th>
                                <th scope="col">Tổng</th>
                                <th scope="col">Hình thức thanh toán</th> <!-- Thêm dòng này -->
                                <th scope="col">Trạng thái</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Chi tiết</th>
                                <th scope="col">Cập nhật</th>
                                <th scope="col">Xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders) && count($orders) > 0): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?php echo $order->id; ?></td>
                                        <td><?php echo $order->name; ?></td>
                                        <td><?php echo $order->phone_number; ?></td>
                                        <td><?php echo $order->address; ?></td>
                                        <td><?php echo $order->detail; ?></td>
                                        <td><?php echo number_format($order->total_price); ?></td>
                                        <td><?php echo htmlspecialchars($order->payment_method); ?></td> <!-- Thêm dòng này -->
                                        <td><?php echo $order->status; ?></td>
                                        <td><?php echo $order->created_at; ?></td>
                                        <td>
                                            <a href="detail_orders.php?id=<?php echo $order->id;?>" class="btn btn-primary">Chi tiết</a>
                                        </td>
                                        <td>
                                            <a href="status.php?id=<?php echo $order->id;?>" class="btn btn-primary">Status</a>
                                        </td>
                                        <td>
                                            <a href="delete_orders.php?id=<?php echo $order->id;?>" class="btn btn-danger text-center">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="12" class="text-center">Không có đơn hàng nào</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require (__DIR__ ."/../layout/footer.php"); ?>

