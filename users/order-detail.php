<?php
require (__DIR__ ."/../libs/App.php");
require (__DIR__ ."/../config/config.php");
require (__DIR__ ."/../includes/header.php");

$app = new App;

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'];

// Lấy thông tin đơn hàng (đảm bảo đúng user)
$order = $app->selectOne("SELECT * FROM orders WHERE id = :id AND user_id = :user_id", [
    ':id' => $order_id,
    ':user_id' => $user_id
]);
if (!$order) {
    echo "<script>alert('Không tìm thấy đơn hàng!');window.location.href='orders.php'</script>";
    exit;
}

// Lấy chi tiết món ăn trong đơn hàng
$order_items = $app->selectAll(
    "SELECT f.name as food_name, od.quantity, od.price 
     FROM orders_detail od 
     JOIN foods f ON f.id = od.food_id 
     WHERE od.order_id = :order_id",
    [':order_id' => $order_id]
);
?>

<div class="container-fluid py-5 bg-dark hero-header mb-5">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Chi tiết</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?php echo APPURL;?>/users/orders.php?id=<?php echo $_SESSION['user_id']?>">Chi tiết</a></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container py-5">
    <h3>Chi tiết đơn hàng #<?php echo $order->id; ?></h3>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Tên món</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0; ?>
            <?php foreach ($order_items as $item): ?>
                <?php $item_total = $item->price * $item->quantity; $total += $item_total; ?>
                <tr>
                    <td><?php echo htmlspecialchars($item->food_name); ?></td>
                    <td><?php echo $item->quantity; ?></td>
                    <td><?php echo number_format($item->price); ?> VNĐ</td>
                    <td><?php echo number_format($item_total); ?> VNĐ</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="text-end fw-bold">Tổng cộng:</td>
                <td class="fw-bold text-danger"><?php echo number_format($total); ?> VNĐ</td>
            </tr>
        </tfoot>
    </table>
    <a href="orders.php" class="btn btn-secondary">Quay lại danh sách đơn hàng</a>
</div>

<?php require (__DIR__ ."/../includes/footer.php"); ?>