<?php require (__DIR__ ."/../libs/App.php"); ?>
<?php require (__DIR__ ."/../config/config.php"); ?>
<?php require (__DIR__ ."/../includes/header.php"); ?>
<?php
    $query = "SELECT * FROM bookings WHERE user_id = '$_SESSION[user_id]'";
    $app = new App;

    $bookings = $app->selectAll($query);


    
?>



<div class="container-fluid py-5 bg-dark hero-header mb-5">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Lịch sử đặt bàn</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?php echo APPURL;?>/users/booking.php?id=<?php echo $_SESSION['user_id']?>">Đặt bàn</a></li>
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
                    <th scope = "col">Ngày đặt bàn</th>
                    <th scope = "col">Số người</th>
                    <th scope = "col">Yêu cầu đặc biệt</th>
                    <th scope = "col">Trạng thái</th>
                    <th scope = "col">Đánh giá</th>

                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <th><?php echo $booking->name ?></th>
                        <td><?php echo $booking->phone_number; ?></td>
                        <td><?php echo $booking->date_booking; ?></td>
                        <td><?php echo $booking->num_people; ?></td>
                        <td><?php echo $booking->special_request; ?></td>
                        <td><?php echo $booking->status; ?></td>
                        <?php if($booking->status == "Hoàn thành"): ?>
                            <td><a href="<?php echo APPURL;?>/users/review.php" class="btn btn-success text white">Đánh giá</a></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
           
            </tbody>
        </table>
    </div>
        
</div>


<?php require (__DIR__ ."/../includes/footer.php"); ?>
