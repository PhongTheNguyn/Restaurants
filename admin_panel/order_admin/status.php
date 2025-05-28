<?php require (__DIR__ ."/../../libs/App.php"); ?>
<?php require (__DIR__ ."/../layout/header.php"); ?>
<?php require (__DIR__ ."/../../config/config.php"); ?>


<?php

    $app = new App;
    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        if (isset($_POST['submit'])) {
            $status = $_POST['status'];
            $query = "UPDATE orders SET status = :status WHERE id = :id";
        
            $arr = [
                ':status' => $status,
                ':id' => $id
            ];

            $path = "orders_admin.php";
            $app->update($query, $arr, $path);
        }   
    }

?>


<div class="row center mt-100">
    <div class="col ">
        <div class="card ">
            <div class="card-body ">
                <h5 class="card-title mt-5">Cập nhật trạng thái đơn hàng</h5>
                <form method="POST" class="p-auto" action="status.php?id=<?php echo $id; ?>">
                    <div class="form-outline mb-4">
                        <select name="status" class="form-control">
                            <option selected>Chọn trạng thái</option>
                            <option value="Pending">Pending</option>
                            <option value="Confirmed">Confirmed</option>
                        </select>
                    </div>
                    <button name="submit" type="submit" class="btn btn-primary">Cập nhật</button>
                </form>
            </div>  
        </div>
    </div>
</div>

<?php require (__DIR__ ."/../layout/footer.php"); ?>

