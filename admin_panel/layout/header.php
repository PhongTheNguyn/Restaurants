<?php 
    $app = new App;
    $app->startingSession();
    define("ADMINURL", "http://localhost/restaurants/admin_panel");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin panel</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/../Restaurants/admin_panel/styles/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div id="wrapper">
        <!-- Top Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="<?php echo ADMINURL; ?>">Admin Mộc Mộc Quán</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <?php if (isset($_SESSION['email'])): ?>
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>" class="nav-link">Trang chủ</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>/admin/admin.php" class="nav-link">Admin</a>
                            </li>    
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>/order_admin/orders_admin.php" class="nav-link">Orders</a>
                            </li>    
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>/foods_admin/show_foods.php" class="nav-link">Thực phẩm</a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>/booking_admin/show_bookings.php" class="nav-link">Bàn đặt</a>
                            </li>    
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>/feelback/feelback.php" class="nav-link">Feedback</a>
                            </li>    
                        </ul>
                    <?php endif; ?>

                    <ul class="navbar-nav ms-auto">
                        <?php if (!isset($_SESSION['email'])): ?>
                            <li class="nav-item">
                                <a href="<?php echo ADMINURL; ?>/admin/login_admin.php" class="nav-link">Đăng nhập</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo htmlspecialchars($_SESSION['email']); ?>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="<?php echo ADMINURL; ?>/admin/logout_admin.php">Đăng xuất</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        
        
            