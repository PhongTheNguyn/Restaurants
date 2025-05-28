<?php require (__DIR__ ."/../../libs/App.php"); ?>
<?php require (__DIR__ ."/../layout/header.php"); ?>
<?php require (__DIR__ ."/../../config/config.php"); ?>
<div class="mt-100"></div>
<?php

    if(!isset($_SERVER['HTTP_REFERER'])) {
        echo "<script>window.location.href='".ADMINURL."'</script>";
        exit;
    }
?>

<?php

    if(isset($_GET["id"])) {
        $id = $_GET["id"];
        $query = "DELETE FROM bookings WHERE id = '$id'";
        $app = new App;
        $path = "show_bookings.php";
        $app->delete($query, $path);
    } else {
        echo "<script>window.location.href='".APPURL."/404.php'</script>";
        exit;
    }

?>