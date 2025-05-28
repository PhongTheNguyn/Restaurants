<?php
require (__DIR__ ."/../../libs/App.php");
require (__DIR__ ."/../layout/header.php");
require (__DIR__ ."/../../config/config.php");

$app = new App;

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($order_id <= 0) {
    echo "<script>alert('Không tìm thấy đơn hàng!');window.location.href='orders_admin.php'</script>";
    exit;
}

// Lấy thông tin đơn hàng
$order = $app->selectOne("SELECT * FROM orders WHERE id = :id", [':id' => $order_id]);
if (!$order) {
    echo "<script>alert('Không tìm thấy đơn hàng!');window.location.href='orders_admin.php'</script>";
    exit;
}

// Lấy chi tiết các món trong đơn hàng
$order_items = $app->selectAll("SELECT f.name as food_name, od.quantity, od.price from orders_detail od join foods f on f.id = od.food_id where od.order_id = :id", [':id' => $order_id]);

// Định nghĩa các class theo trạng thái
$statusClasses = [
    'Pending' => 'bg-warning text-dark',
    'Confirmed' => 'bg-success text-white',
    'Completed' => 'bg-info text-white',
    'Cancelled' => 'bg-danger text-white'
];

$statusClass = isset($statusClasses[$order->status]) ? $statusClasses[$order->status] : 'bg-secondary text-white';
?>

<div class="container-fluid p-0 mb-4">
    <div class="bg-primary text-white p-3 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fa fa-shopping-cart me-2"></i>Chi tiết đơn hàng #<?php echo $order->id; ?></h4>
            <span class="badge <?php echo $statusClass; ?> fs-6"><?php echo htmlspecialchars($order->status ?? 'Pending'); ?></span>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <!-- Cột thông tin khách hàng -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="text-primary mb-3">Thông tin khách hàng</h5>
                        <div class="mb-2">
                            <strong>Khách hàng:</strong> <?php echo htmlspecialchars($order->name); ?>
                        </div>
                        <div class="mb-2">
                            <strong>Số điện thoại:</strong> <?php echo htmlspecialchars($order->phone_number); ?>
                        </div>
                        <div class="mb-2">
                            <strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order->address); ?>
                        </div>
                        <div>
                            <strong>Ghi chú:</strong> <?php echo htmlspecialchars($order->detail ?? 'Không có'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Cột thông tin đơn hàng -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="text-primary mb-3">Thông tin đơn hàng</h5>
                        <div class="mb-2">
                            <strong>Thời gian đặt:</strong> <?php echo htmlspecialchars($order->created_at); ?>
                        </div>
                        <div class="mb-2">
                            <strong>Tổng giá trị:</strong> <span class="text-danger fw-bold"><?php echo number_format($order->total_price); ?> VNĐ</span>
                        </div>
                        <div class="mb-2">
                            <strong>Trạng thái đơn:</strong> <?php echo htmlspecialchars($order->status); ?>
                        </div>
                        <div>
                            <strong>Mã đơn hàng:</strong> DH<?php echo str_pad($order->id, 6, '0', STR_PAD_LEFT); ?>
                        </div>
                    </div>
                </div>
            </div>        </div>
        
        <!-- Danh sách món đã đặt -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="text-primary mb-3">Danh sách món đã đặt</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="bg-light">
                            <tr>
                                <th>STT</th>
                                <th>Tên món</th>
                                <th class="text-center">Số lượng</th>
                                <th class="text-end">Giá</th>
                                <th class="text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody><?php
            $total = 0;
            if ($order_items) {
                $stt = 1;
                foreach ($order_items as $item) {
                    $item_total = $item->price * $item->quantity;
                    $total += $item_total;
                    echo "<tr>
                        <td>{$stt}</td>
                        <td>".htmlspecialchars($item->food_name)."</td>
                        <td class=\"text-center\">{$item->quantity}</td>
                        <td class=\"text-end\">".number_format($item->price)." VNĐ</td>
                        <td class=\"text-end\">".number_format($item_total)." VNĐ</td>
                    </tr>";
                    $stt++;
                }
            } else {
                echo '<tr><td colspan="5" class="text-center">Không có món nào</td></tr>';
            }
            ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Tổng cộng:</td>
                            <td class="text-end fw-bold text-danger"><?php echo number_format($order->total_price); ?> VNĐ</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
            <div class="mt-4">
                <h5 class="text-primary mb-3"><i class="fa fa-history me-2"></i>Lịch sử đơn hàng</h5>
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-transparent d-flex justify-content-between">
                                <div><i class="fa fa-calendar-check me-2"></i> Đơn hàng đã tạo</div>
                                <div><?php echo htmlspecialchars($order->created_at); ?></div>
                            </li>
                            <?php if ($order->status != 'Pending'): ?>
                            <li class="list-group-item bg-transparent d-flex justify-content-between">
                                <div><i class="fa fa-check-circle me-2"></i> Đã xác nhận đơn hàng</div>
                                <div><?php echo date('Y-m-d H:i:s', strtotime($order->created_at . ' +1 hour')); ?></div>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="d-flex flex-wrap gap-2 mt-4 justify-content-between">
                <div>
                    <a href="orders_admin.php" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-2"></i>Quay lại danh sách
                    </a>
                </div>
                <div class="d-flex gap-2">
                    <?php if ($order->status == 'Pending'): ?>
                        <a href="status.php?id=<?php echo $order->id;?>" class="btn btn-success">
                            <i class="fa fa-check-circle me-2"></i>Xác nhận đơn hàng
                        </a>
                    <?php endif; ?>
                    <a href="javascript:void(0);" onclick="printOrder()" class="btn btn-primary">
                        <i class="fa fa-print me-2"></i>In đơn hàng
                    </a>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function printOrder() {
    window.print();
}
</script>