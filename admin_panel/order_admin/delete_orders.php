<?php require (__DIR__ ."/../../libs/App.php"); ?>
<?php require (__DIR__ ."/../layout/header.php"); ?>
<?php require (__DIR__ ."/../../config/config.php"); ?>

<?php

    if(!isset($_SERVER['HTTP_REFERER'])) {
        echo "<script>window.location.href='".ADMINURL."'</script>";
        exit;
    }
?>

<?php

    if(isset($_GET["id"])) {
        $id = intval($_GET["id"]);
        $app = new App;
        $path = "orders_admin.php";

        // Xóa chi tiết đơn hàng trước
        $app->delete("DELETE FROM orders_detail WHERE order_id = '$id'", $path);

        // Sau đó xóa đơn hàng
        $app->delete("DELETE FROM orders WHERE id = '$id'", $path);
    } else {
        echo "<script>window.location.href='".APPURL."/404.php'</script>";
        exit;
    }
    

?>