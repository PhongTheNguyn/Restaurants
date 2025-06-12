<?php require (__DIR__ ."/../libs/App.php"); ?>
<?php require (__DIR__ ."/layout/header.php"); ?>
<?php require (__DIR__ ."/../config/config.php"); ?>

<?php
    $app = new App;
    $app->validateSessionAdminInside();

    // Thống kê tổng quan
    $count_foots = $app->selectOne("SELECT COUNT(*) AS count_foots FROM foods");
    $count_orders = $app->selectOne("SELECT COUNT(*) AS count_orders FROM orders");
    $count_bookings = $app->selectOne("SELECT COUNT(*) AS count_bookings FROM bookings");
    $count_admins = $app->selectOne("SELECT COUNT(*) AS count_admins FROM admins");

    // Tổng doanh thu (theo trạng thái Confirmed hoặc Completed)
    $total_revenue = $app->selectOne("SELECT SUM(total_price) AS total_revenue FROM orders WHERE status IN ('Confirmed','Completed')");

    // Doanh thu từng tháng (theo trạng thái Confirmed hoặc Completed)
    $monthly_revenue = $app->selectAll("
        SELECT MONTH(created_at) as month, SUM(total_price) as revenue
        FROM orders
        WHERE status IN ('Confirmed','Completed') AND YEAR(created_at) = YEAR(CURDATE())
        GROUP BY MONTH(created_at)
        ORDER BY month
    ");
    $revenue_data = array_fill(0, 12, 0);
    foreach ($monthly_revenue as $row) {
        $revenue_data[intval($row->month) - 1] = floatval($row->revenue);
    }
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
                <p class="card-text">Số lượng: <?php echo $count_orders->count_orders; ?></p>
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
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Tổng doanh thu</h5>
                <p class="card-text">
                    <?php echo number_format($total_revenue->total_revenue ?? 0); ?> VNĐ
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-12 d-flex justify-content-center">
        <div style="width:80%;">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Biểu đồ doanh thu theo tháng (<?php echo date('Y'); ?>)</h5>
                    <canvas id="revenueChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: <?php echo json_encode(array_values($revenue_data)); ?>,
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + ' VNĐ';
                        }
                    }
                }
            }
        }
    });
</script>

<?php require (__DIR__ ."../layout/footer.php"); ?>