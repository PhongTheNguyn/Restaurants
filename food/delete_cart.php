<?php require (__DIR__ ."/../libs/App.php"); ?>
<?php require (__DIR__ ."/../config/config.php"); ?>
<?php require (__DIR__ ."/../includes/header.php"); ?>

<?php

    if(!isset($_SERVER['HTTP_REFERER'])) {
        echo "<script>window.location.href='".APPURL."'</script>";
        exit;
    }
?>

<?php


$user_id = $_SESSION["user_id"];
$app->insert("DELETE FROM cart WHERE user_id = :user_id", [':user_id' => $user_id], null);

?>