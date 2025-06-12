<?php require(__DIR__ . "/../libs/App.php"); ?>
<?php require(__DIR__ . "/../config/config.php"); ?>
<?php require(__DIR__ . "/../includes/header.php"); ?>
<?php

if (!isset($_SERVER['HTTP_REFERER'])) {
    echo "<script>window.location.href='" . APPURL . "'</script>";
    exit;
}
?>



<?php
$app = new App;


if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $phone_number = $_POST["phone_number"];
    $address = $_POST["address"];
    $detail = $_POST["detail"];
    $user_id = $_SESSION["user_id"]; 
    $payment_method = isset($_POST["payment_method"]) ? $_POST["payment_method"] : "Tiền mặt";
    $total_price = $app->selectOne("SELECT SUM(price * quantity) AS total FROM cart WHERE user_id = :user_id", [':user_id' => $user_id])->total;
    if ($total_price === null) $total_price = 0;

    $query = "INSERT INTO orders (name, phone_number, address, detail, total_price, user_id, payment_method) VALUES (:name, :phone_number, :address, :detail, :total_price, :user_id, :payment_method)";
    $arr = [
        ":name" => $name,
        ":phone_number" => $phone_number,
        ":address" => $address,
        ":detail" => $detail,
        ":total_price" => $total_price,
        ":user_id" => $user_id,
        ":payment_method" => $payment_method
    ];
    $order_id = $app->insertAndGetId($query, $arr); // Bạn cần có hàm này trong App

    // 2. Lấy các món trong giỏ hàng
    $cart_items = $app->selectAll("SELECT * FROM cart WHERE user_id = :user_id", [':user_id' => $user_id]);

    // 3. Thêm từng món vào orders_detail
    foreach ($cart_items as $item) {
        $arrDetail = [
            ':order_id' => $order_id,
            ':food_id' => $item->item_id, // hoặc $item->food_id tùy bảng cart
            ':quantity' => $item->quantity,
            ':price' => $item->price
        ];
        $app->insert(
            "INSERT INTO orders_detail (order_id, food_id, quantity, price) VALUES (:order_id, :food_id, :quantity, :price)",
            $arrDetail,
            null
        );
    }

    $app->insert("DELETE FROM cart WHERE user_id = :user_id", [':user_id' => $user_id], null);

    // Có thể chuyển hướng hoặc thông báo thành công
    echo "<script>alert('Đặt hàng thành công!');window.location.href='cart.php';</script>";
    exit;


    
}

?>

<div class="container-fluid py-5 bg-dark hero-header mb-5">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Thanh toán</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="#">Thanh toán</a></li>
            </ol>
        </nav>
    </div>
</div>


<div class="container">
    <div class="col-md-12 bg-dark wow fadeInUp p-5" data-wow-delay='0.2s'>

        <h5 class="sectione-title ff-secondary text-start text-primary fw-normal"></h5>
        <h1 class="text-white mb-4">Thanh toán</h1>
        <form method="POST" action="checkout.php" class="col-md-12">
            <div class="row g-3">
                <div class="col-md-12">
                    <div class="form-floading">

                        <input type="text" name="name" id="name" class="form-control">
                        <label for="text">Họ và tên</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floading">

                        <input type="text" name="phone_number" id="phone_number" class="form-control">
                        <label for="text">Số điện thoại</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floading">

                        <input type="text" name="address" id="address" class="form-control"></textarea>
                        <label for="message">Địa chỉ</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-floading">

                        <textarea type="text" name="detail" id="detail" class="form-control"></textarea>
                        <label for="message">Chi tiết</label>
                    </div>
                </div>                
                <form method="POST" action="checkout.php" class="col-md-12">
                    <!-- ...các input khác... -->
                    <input type="hidden" name="payment_method" value="Tiền mặt">
                    <button name="submit" class="btn btn-primary w-100 py-3 mb-3" action ="delete_cart.php" type="submit">Thanh toán tiền mặt</button>
                </form>
                    
            </div>
        </form>

        <div class="row mt-4">
            <div class="col-md-6 mb-3">
                <form method="POST" target="_blank" enctype="application/x-www-form-urlencoded" action="qr.php">
                    <input type="hidden" name="name" value="">
                    <input type="hidden" name="phone_number" value="">
                    <input type="hidden" name="address" value="">
                    <input type="hidden" name="detail" value="">
                    <input type="hidden" name="payment_method" value="QR">
                    <button name="momo" class="btn btn-primary w-100 py-3" type="submit">Thanh toán MOMO QR</button>
                </form>
            </div>
            <div class="col-md-6">
                <form method="POST" target="_blank" enctype="application/x-www-form-urlencoded" action="atm.php">
                    <input type="hidden" name="name" value="">
                    <input type="hidden" name="phone_number" value="">
                    <input type="hidden" name="address" value="">
                    <input type="hidden" name="detail" value="">
                    <input type="hidden" name="payment_method" value="ATM">
                    <button name="momo" class="btn btn-primary w-100 py-3" type="submit">Thanh toán MOMO ATM</button>
                </form>
            </div>
        </div>    </div>
</div>




<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lắng nghe sự kiện focus vào các form MOMO
    const momoForms = document.querySelectorAll('form[action="qr.php"], form[action="atm.php"]');
    
    momoForms.forEach(form => {
        form.addEventListener('submit', function() {
            // Lấy giá trị từ form chính
            const nameValue = document.getElementById('name').value;
            const phoneValue = document.getElementById('phone_number').value;
            const addressValue = document.getElementById('address').value;
            const detailValue = document.getElementById('detail').value;
            
            // Cập nhật các trường ẩn trong form MOMO
            form.querySelector('input[name="name"]').value = nameValue;
            form.querySelector('input[name="phone_number"]').value = phoneValue;
            form.querySelector('input[name="address"]').value = addressValue;
            form.querySelector('input[name="detail"]').value = detailValue;
        });
    });
});
</script>

<?php require(__DIR__ . "/../includes/footer.php"); ?>