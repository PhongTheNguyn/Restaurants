<?php 
session_start();
unset($_SESSION['admin_name']);
unset($_SESSION['email']);
header("Location: http://localhost/restaurants/admin_panel/admin/login_admin.php");
exit();