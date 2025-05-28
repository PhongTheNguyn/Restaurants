<?php
require(__DIR__ . "/../../libs/App.php");
require(__DIR__ . "/../layout/header.php");
require(__DIR__ . "/../../config/config.php");
?>

<?php 


    $app = new App;
    $app->validateSessionAdminInside();

    $search_phone = isset($_GET['search_phone']) ? trim($_GET['search_phone']) : '';
    if ($search_phone !== '') {
        $query = "SELECT * FROM bookings WHERE phone_number LIKE :phone";
        $bookings = $app->selectAll($query, [':phone' => '%' . $search_phone . '%']);
    } else {
        $query = "SELECT * FROM bookings";
        $bookings = $app->selectAll($query);
    }
?>


<div class="row center mt-100">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4 d-inline mt-5  ">Đặt bàn</h5>
            <form method="GET" action="show_bookings.php" class="mb-3">
                <div class="input-group" style="max-width:400px;">
                    <input type="text" class="form-control" name="search_phone" placeholder="Tìm theo số điện thoại..." value="<?php echo isset($_GET['search_phone']) ? htmlspecialchars($_GET['search_phone']) : ''; ?>">
                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                </div>
            </form>
            <div class="table">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên khách hàng</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Thời gian nhận bàn</th>
                            <th scope="col">Số người</th>
                            <th scope="col">Yêu cầu đặc biệt</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thời gian đặt bàn</th>
                            <th scope="col">Sửa Trạng thái</th>
                            <th scope="col">Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($bookings) && count($bookings) > 0): ?>
                            <?php foreach ($bookings as $booking): ?>
                                <tr>
                                    <td><?php echo $booking->id; ?></td>
                                    <td><?php echo $booking->name; ?></td>
                                    <td><?php echo $booking->phone_number; ?></td>
                                    <td><?php echo $booking->date_booking; ?></td>
                                    <td><?php echo $booking->num_people; ?></td>
                                    <td><?php echo $booking->special_request; ?></td>
                                    <td><?php echo $booking->status; ?></td>

                                    <td><?php echo $booking->	created_at; ?></td>
                                    <td>
                                        <a href="status.php?id=<?php echo $booking->id;?>" class="btn btn-primary text-center">Trạng thái</a>
                                    </td>
                                    <td>
                                        <a href="delete_bookings.php?id=<?php echo $booking->id;?>" class="btn btn-danger text-center">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="10" class="text-center">Không có đặt bàn nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>





<?php require(__DIR__ . "/../layout/footer.php"); ?>
  