<?php require (__DIR__ ."/../libs/App.php"); ?>
<?php require (__DIR__ ."/../config/config.php"); ?>
<?php require (__DIR__ ."/../includes/header.php"); ?>
<?php
    $query = "SELECT * FROM cart WHERE user_id = '$_SESSION[user_id]'";
    $app = new App;

    $cart_items = $app->selectAll($query);


    $cart_price = $app->selectOne("SELECT SUM(price * quantity) AS all_price FROM cart WHERE user_id = '$_SESSION[user_id]'");

    if ($cart_price->all_price === NULL) {
        $cart_price->all_price = 0;
    }

    if(isset($_POST["submit"])) {
        $_SESSION['total_price'] = $cart_price->all_price;

        echo "<script>window.location.href='checkout.php'</script>";
    }
?>



<div class="container-fluid py-5 bg-dark hero-header mb-5">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Giỏ hàng</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#">Giỏ hàng</a></li>
            </ol>
        </nav>
    </div>
</div>



<div class="container">
    <div class="col-md-12">
        <table class="table">
    <thead>
        <tr>
            <th scope="col">Ảnh sản phẩm</th>
            <th scope="col">Tên sản phẩm</th>
            <th scope="col">Giá sản phẩm</th>
            <th scope="col">Số lượng</th>
            <th scope="col">Thành tiền</th>
            <th scope="col">Xóa</th>
        </tr>
    </thead>
    <tbody>
    <?php
        $total = 0;
        if (!empty($cart_items) && count($cart_items) > 0):
            foreach ($cart_items as $item):
                $item_total = $item->price * $item->quantity;
                $total += $item_total;
    ?>
        <tr>
            <th><img src="<?php echo APPIMG;?>/<?php echo $item->image; ?>" style="width: 50px; height: 50px;" alt=""></th>
            <td><?php echo $item->name; ?></td>
            <td><?php echo number_format($item->price); ?> VNĐ</td>
            <td><?php echo $item->quantity; ?></td>
            <td><?php echo number_format($item_total); ?> VNĐ</td>
            <td><a href="<?php echo APPURL; ?>/food/delete-item.php?id=<?php echo $item->id; ?>" class="btn btn-danger text-white">Xóa</a></td>
        </tr>
    <?php
            endforeach;
        else:
    ?>
        <tr>
            <td colspan="6" class="text-center">Giỏ hàng trống</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
<div class="position-relative mx-auto" style="max-width: 400px; padding-left: 679px;"></div>
<p style="margin-left: -7px" class="w-19 py-3 ps-4 pr-5" type="text">
    Tổng: <?php echo number_format($total); ?> VNĐ
</p>
<form method="POST" action="cart.php">
    <button name="submit" type="submit" class="btn btn-primary py-2 top-0 end-0 mt-2 me-2">Thanh toán</button>
</form>
    </div>
</div>


<?php require (__DIR__ ."/../includes/footer.php"); ?>
