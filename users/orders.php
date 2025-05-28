<?php require (__DIR__ ."/../libs/App.php"); ?>
<?php require (__DIR__ ."/../config/config.php"); ?>
<?php require (__DIR__ ."/../includes/header.php"); ?>
<?php
    $query = "SELECT * FROM orders WHERE user_id = '$_SESSION[user_id]'";
    $app = new App;

    $orders = $app->selectAll($query);


    
?>



<div class="container-fluid py-5 bg-dark hero-header mb-5">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown">Orders</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="<?php echo APPURL;?>/users/orders.php?id=<?php echo $_SESSION['user_id']?>">Orders</a></li>
            </ol>
        </nav>
    </div>
</div>



<div class="container">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th scope = "col">name</th>
                    <th scope = "col">phone_number</th>
                    <th scope = "col">address</th>
                    <th scope = "col">detail</th>
                    <th scope = "col">total_price</th>
                    <th scope = "col">status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <th><?php echo $order->name ?></th>
                        <td><?php echo $order->phone_number; ?></td>
                        <td><?php echo $order->address; ?></td>
                        <td><?php echo $order->detail; ?></td>
                        <td><?php echo number_format($order->total_price); ?></td>
                        <td><?php echo $order->status; ?></td>

                    </tr>
                <?php endforeach; ?>
           
            </tbody>
        </table>
    </div>
        
</div>


<?php require (__DIR__ ."/../includes/footer.php"); ?>
