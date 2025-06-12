<?php require (__DIR__ ."/../libs/App.php"); ?>
<?php require (__DIR__ ."/../config/config.php"); ?>
<?php require (__DIR__ ."/../includes/header.php"); ?>
<?php
    $query = "SELECT * FROM orders WHERE user_id = '$_SESSION[user_id]'";
    $app = new App;

    $orders = $app->selectAll($query);


    
?>



<div class="container-fluid py-5 bg-dark hero-header mb-5">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Lịch sử đặt hàng</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?php echo APPURL;?>/users/orders.php?id=<?php echo $_SESSION['user_id']?>">Orders</a></li>
            </ol>
        </nav>
    </div>
</div>



<div class="container">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th scope = "col">Họ tên</th>
                    <th scope = "col">Số điện thoại</th>
                    <th scope = "col">Địa chỉ</th>
                    <th scope = "col">Yêu cầu</th>
                    <th scope = "col">Tổng</th>
                    <th scope = "col">Trạng thái</th>
                    <th scope = "col">Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <th><?php echo $order->name ?></th>
                        <td><?php echo $order->phone_number; ?></td>
                        <td><?php echo $order->address; ?></td>
                        <td><?php echo $order->detail; ?></td>
                        <td><?php echo number_format($order->total_price); ?></td>
                        <td><?php echo $order->status; ?></td>
                        <td>
                            <a href="order-detail.php?id=<?php echo $order->id; ?>" class="btn btn-primary btn-sm">Xem</a>
                        </td>

                    </tr>
                <?php endforeach; ?>
           
            </tbody>
        </table>
    </div>
        
</div>


<?php require (__DIR__ ."/../includes/footer.php"); ?>
