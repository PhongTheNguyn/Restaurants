<?php require (__DIR__ ."/../libs/App.php"); ?>
<?php require (__DIR__ ."/../config/config.php"); ?>
<?php require (__DIR__ ."/../includes/header.php"); ?>
<?php 



if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM foods WHERE id = '$id'";
    $app = new App;

    $one = $app->selectOne($query);
   



    if(isset($_SESSION['user_id'])) {
        $q = "SELECT * FROM cart WHERE item_id = '$id' AND user_id = '$_SESSION[user_id]'";
        $count = $app->validateCart($q);

    }

    
    if(isset($_POST["submit"])) {
        $item_id = $_POST["item_id"];
        $name = $_POST["name"];
        $price = $_POST["price"];
        $image = $_POST["image"];
        $user_id = $_SESSION["user_id"];
        $quantity = isset($_POST["quantity"]) ? intval($_POST["quantity"]) : 1;

        // Kiểm tra xem món đã có trong giỏ chưa
        $cart_item = $app->selectOne(
            "SELECT * FROM cart WHERE item_id = :item_id AND user_id = :user_id",
            [':item_id' => $item_id, ':user_id' => $user_id]
        );

        if ($cart_item) {
            // Nếu đã có, cập nhật số lượng
            $new_quantity = $cart_item->quantity + $quantity;
            $app->insert(
                "UPDATE cart SET quantity = :quantity WHERE item_id = :item_id AND user_id = :user_id",
                [
                    ':quantity' => $new_quantity,
                    ':item_id' => $item_id,
                    ':user_id' => $user_id
                ],
                null
            );

            header("Location: add-cart.php?id=$item_id&success=1");
            exit;
        } else {
            // Nếu chưa có, thêm mới
            $query = "INSERT INTO cart (item_id, name, price, image, user_id, quantity) VALUES (:item_id, :name, :price, :image, :user_id, :quantity)";
            $arr = [
                ":item_id" => $item_id,
                ":name"=> $name,
                ":price"=> $price,
                ":image"=> $image,
                ":user_id"=> $user_id,
                ":quantity"=> $quantity
            ];
            $app->insert($query, $arr, null);
            header("Location: add-cart.php?id=$item_id&success=1");
            exit;
        }
    }

}  else{
    echo "<script>window.location.href='".APPURL."/404.php'</script>";
}

$success = (isset($_GET['success']) && $_GET['success'] == 1);
?>

<div class="container-fluid py-5 bg-dark hero-header mb-5">
    <div class="container text-center my-5 pt-5 pb-4">
        <h1 class="display-3 text-white mb-3 animated slideInDown"><?php echo $one->name;?></h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center text-uppercase">
                <li class="breadcrumb-item"><a href="<?php echo APPURL;?>/index.php">Trang chủ</a></li>
                <li class="breadcrumb-item text-white active" aria-current="page"><?php echo $one->name;?></li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid py-5">
    <div class="container">
        <?php if ($success): ?>
            <div class="alert alert-success mt-3">Đã thêm vào giỏ hàng!</div>
        <?php endif; ?>
        <div class="row g-5 align-item-center">
            <div class="col-md-6">
                <div class="row g-3">
                    <div class="col-12 text-start">
                        <img class="img-fluid rounded w-100 wow zoomIn" data-wow-delay="0.1s" src="<?php echo APPIMG;?>/<?php echo $one->image;?>" >
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h1 class="mb-4"><?php echo $one->name;?></h1>
                <p class="mb-4">
                    <?php echo $one->description;?>
                </p>
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-item-center border-start border-5 border-primary px-3">
                            <h3>Price: <?php echo number_format($one->price);?> VNĐ</h3>
                        </div>
                    </div>
                </div>
                <form method="POST" action="add-cart.php?id=<?php echo $id?>">
                    <input type="hidden" name="item_id" value="<?php echo $one->id;?>">
                    <input type="hidden" name="name" value="<?php echo $one->name;?>">
                    <input type="hidden" name="image" value="<?php echo $one->image;?>">
                    <input type="hidden" name="price" value="<?php echo $one->price;?>">
                    <div class="mb-3">
                        <label for="quantity">Số lượng:</label>
                        <input type="number" name="quantity" id="quantity" class="form-control w-25 d-inline" value="1" min="1" required>
                    </div>
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <button name="submit" type="submit" class="btn btn-primary py-3 px-5 mt-2">Thêm vào giỏ</button>
                    <?php else: ?>
                        <a href="<?php echo APPURL;?>/auth/login.php" class="btn btn-primary py-3 px-5 mt-2">Đăng nhập để thêm vào giỏ</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>
                    
                


<?php require (__DIR__ ."/../includes/footer.php"); ?>
