<?php require (__DIR__ ."/../libs/App.php"); ?>
<?php require (__DIR__ ."/layout/header.php"); ?>
<?php require (__DIR__ ."/../config/config.php"); ?>

<?php

    $app = new App;
    $app->validateSessionAdminInside();


    $query = "SELECT COUNT(*) AS count_foots FROM foods";
    $count_foots = $app->selectOne($query);

    $query = "SELECT COUNT(*) AS count_orders FROM orders";
    $count_orders = $app->selectOne($query);

    $query = "SELECT COUNT(*) AS count_bookings FROM bookings";
    $count_bookings = $app->selectOne($query);

    $query = "SELECT COUNT(*) AS count_admins FROM admins";
    $count_admins = $app->selectOne($query);
?>

<div class="row center mt-100">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thống kê món ăn</h5>
                <p class="card-text">Số lượng món ăn: <?php echo $count_foots->count_foots; ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thống kê đặt món</h5>
                <p class="card-text">Số lượng : <?php echo $count_orders->count_orders; ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thống kê đặt bàn</h5>
                <p class="card-text">Số lượng đặt bàn: <?php echo $count_bookings->count_bookings; ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Thống kê admin</h5>
                <p class="card-text">Số lượng admin: <?php echo $count_admins->count_admins; ?></p>
            </div>
        </div>
    </div>
</div>


















<?php require (__DIR__ ."../layout/footer.php"); ?>
