<?php require (__DIR__ ."/../../libs/App.php"); ?>
<?php require (__DIR__ ."/../layout/header.php"); ?>
<?php require (__DIR__ ."/../../config/config.php"); ?>

<?php

$app = new App;
$app->validateSessionAdmin();
if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT * FROM admins WHERE email = :email";
    $data = [
        ":email" => $email,
        ":password" => $password,
    ];

    $path = "http://localhost/restaurants/admin_panel";

    $app->loginAdmin($query, $data, $path);
}

?>

<div class="row center mt-100">
    <div class="col ">
        <div class="card ">
            <div class="card-body ">
                <h5 class="card-title mt-5">Đăng nhập</h5>
                <form method="POST" class="p-auto" action="login_admin.php">
                    <div class="form-outline mb-4">
                        <input type="email" class="form-control" id="form2Example1" placeholder="Email" name="email" required>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" class="form-control" id="form2Example2" placeholder="Mật khẩu" name="password" required>
                    </div>
                    <button name="submit" type="submit" class="btn btn-primary">Đăng nhập</button>
                </form>
            </div>
        </div>
    </div>
</div>