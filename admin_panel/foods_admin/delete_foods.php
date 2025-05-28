<?php
require(__DIR__ . "/../../libs/App.php");
require(__DIR__ . "/../layout/header.php");
require(__DIR__ . "/../../config/config.php");
?>

<?php

    if(!isset($_SERVER['HTTP_REFERER'])) {
        echo "<script>window.location.href='".APPURL."'</script>";
        exit;
    }
?>

<?php

    if(isset($_GET["id"])) {
        $id = $_GET["id"];

        $query = "SELECT * FROM foods WHERE id =  '$id'";
   
        unlink("foods_images" . $one->image); // Xóa hình ảnh nếu tồn tại
 




        $query = "DELETE FROM foods WHERE id = '$id'";
        $app = new App;
        $path = "show_foods.php";
        $app->delete($query, $path);
    } else {
        echo "<script>window.location.href='".APPURL."/404.php'</script>";
        exit;
    }
?>