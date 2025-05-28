
<?php require (__DIR__ ."/../libs/App.php"); ?>
<?php require (__DIR__ ."/../config/config.php"); ?>
<?php require (__DIR__ ."/../includes/header.php"); ?>

<?php
$app = new App;
$app->validateSession();



if (isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT * FROM users WHERE email = :email";
    $data = [
        ":email" => $email,
        ":password" => $password,
    ];

    $path = "http://localhost/restaurants";

    try {
        $app->loginUser($query, $data, $path);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<div class="container-fluid py-5 bg-dark hero-header mb-5">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Đăng nhập</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#">TRang chủ</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page">Đăng nhập</li>
            </ol>
        </nav>
    </div>
</div>

<div class="register-container mt-5">
    <h5 class="register-title pb-4">Đăng nhập</h5>
    <form method="POST" action="login.php">
        <div class="mb-3">
            <input name="email" type="email" class="form-control" placeholder="Tài Khoản" required>
        </div>
        <div class="mb-3">
            <input name="password" type="password" class="form-control" placeholder="Mật khẩu" required>
        </div>
        <button name="submit" type="submit" class="btn btn-custom w-100 mt-4">Đăng nhập</button>
    </form>
</div>


<?php require (__DIR__ ."/../includes/footer.php"); ?>