<?php require (__DIR__ ."/libs/App.php"); ?>
<?php require (__DIR__ ."/includes/header.php"); ?>
<?php require (__DIR__ ."/config/config.php"); ?>



<?php
$app = new App;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$active_tab = 1; // Mặc định tab 1

if ($search !== '') {
    $query = "SELECT * FROM foods WHERE (name LIKE :search OR description LIKE :search)";
    $foods = $app->selectAll($query, [':search' => '%' . $search . '%']);

    // Nếu có kết quả, lấy meal_id đầu tiên để active đúng tab
    if (!empty($foods)) {
        $active_tab = $foods[0]->meal_id;
    }
} else {
    $query = "SELECT * FROM foods WHERE meal_id='1'";
    $meal_1 = $app->selectAll($query);

    $query = "SELECT * FROM foods WHERE meal_id='2'";
    $meal_2 = $app->selectAll($query);

    $query = "SELECT * FROM foods WHERE meal_id='3'";
    $meal_3 = $app->selectAll($query);
}
?>


            <div class="container-fluid py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Menu</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item"><a href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Menu</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Menu Start -->
        <div class="container-xxl py-5">
            <div class="container">
                <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                    <h5 class="section-title ff-secondary text-center text-primary fw-normal">Menu</h5>
                </div>
                <div class="container text-center my-5">
                    <form method="GET" action="menu.php">
                        <input type="text" name="search" class="form-control w-50 d-inline" placeholder="Tìm kiếm món ăn..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        <button type="submit" class="btn btn-primary">Tìm kiếm</button>
                    </form>
                </div>
                <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 <?php echo ($active_tab == 1) ? 'active' : ''; ?>" data-bs-toggle="pill" href="#tab-1">
                            <i class="fa fa-coffee fa-2x text-primary"></i>
                            <div class="ps-3">
                                <small class="text-body">Popular</small>
                                <h6 class="mt-n1 mb-0">Breakfast</h6>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 pb-3 <?php echo ($active_tab == 2) ? 'active' : ''; ?>" data-bs-toggle="pill" href="#tab-2">
                            <i class="fa fa-hamburger fa-2x text-primary"></i>
                            <div class="ps-3">
                                <small class="text-body">Special</small>
                                <h6 class="mt-n1 mb-0">Launch</h6>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="d-flex align-items-center text-start mx-3 me-0 pb-3 <?php echo ($active_tab == 3) ? 'active' : ''; ?>" data-bs-toggle="pill" href="#tab-3">
                            <i class="fa fa-utensils fa-2x text-primary"></i>
                            <div class="ps-3">
                                <small class="text-body">Lovely</small>
                                <h6 class="mt-n1 mb-0">Dinner</h6>
                            </div>
                        </a>
                    </li>
                </ul>
                    <div class="tab-content">
                        <div id="tab-1" class="tab-pane fade show p-0 <?php echo ($active_tab == 1) ? 'active' : ''; ?>">
                            <div class="row g-4">
                                <?php if ($search !== ''): ?>
                                    <?php if ($active_tab == 1): ?>
                                        <?php foreach($foods as $food): ?>
                                            <?php if($food->meal_id == 1): ?>                              
                                                <div class="col-lg-6">
                                                    <div class="d-flex align-items-center">
                                                        <img class="flex-shrink-0 img-fluid rounded" src="<?php echo APPIMG;?>/<?php echo $food->image;?>" alt="" style="width: 80px;">
                                                        <div class="w-100 d-flex flex-column text-start ps-4">
                                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                                    <span><?php echo $food->name; ?></span>
                                                                    <span class="text-primary"><?php echo number_format($food->price); ?> VNĐ</span>
                                                            </h5>
                                                            <small class="fst-italic"><?php echo $food->description;?></small>
                                                            <a type="button" href="<?php echo APPURL ?>/food/add-cart.php?id=<?php echo $food->id; ?>" class="btn btn-primary py-2 top-0 end-0 mt-2 me-2">view</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php foreach($meal_1 as $meal): ?>
                                        <div class="col-lg-6">
                                            <div class="d-flex align-items-center">
                                                <img class="flex-shrink-0 img-fluid rounded" src="<?php echo APPIMG;?>/<?php echo $meal->image;?>" alt="" style="width: 80px;">
                                                <div class="w-100 d-flex flex-column text-start ps-4">
                                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                            <span><?php echo $meal->name; ?></span>
                                                            <span class="text-primary"><?php echo number_format($meal->price); ?> VNĐ</span>
                                                    </h5>
                                                    <small class="fst-italic"><?php echo $meal->description;?></small>
                                                    <a type="button" href="<?php echo APPURL ?>/food/add-cart.php?id=<?php echo $meal->id; ?>" class="btn btn-primary py-2 top-0 end-0 mt-2 me-2">view</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Tab 2 -->
                        <div id="tab-2" class="tab-pane fade show p-0 <?php echo ($active_tab == 2) ? 'active' : ''; ?>">
                            <div class="row g-4">
                                <?php if ($search !== ''): ?>
                                    <?php if ($active_tab == 2): ?>
                                        <?php foreach($foods as $food): ?>
                                            <?php if($food->meal_id == 2): ?>
                                                <div class="col-lg-6">
                                                    <div class="d-flex align-items-center">
                                                        <img class="flex-shrink-0 img-fluid rounded" src="<?php echo APPIMG;?>/<?php echo $food->image;?>" alt="" style="width: 80px;">
                                                        <div class="w-100 d-flex flex-column text-start ps-4">
                                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                                <span><?php echo $food->name; ?></span>
                                                                <span class="text-primary"><?php echo number_format($food->price); ?> VNĐ</span>
                                                            </h5>
                                                            <small class="fst-italic"><?php echo $food->description;?></small>
                                                            <a type="button" href="<?php echo APPURL ?>/food/add-cart.php?id=<?php echo $food->id; ?>" class="btn btn-primary py-2 top-0 end-0 mt-2 me-2">view</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php foreach($meal_2 as $meal): ?>
                                        <div class="col-lg-6">
                                            <div class="d-flex align-items-center">
                                                <img class="flex-shrink-0 img-fluid rounded" src="<?php echo APPIMG;?>/<?php echo $meal->image;?>" alt="" style="width: 80px;">
                                                <div class="w-100 d-flex flex-column text-start ps-4">
                                                    <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                        <span><?php echo $meal->name; ?></span>
                                                        <span class="text-primary"><?php echo number_format($meal->price); ?> VNĐ</span>
                                                    </h5>
                                                    <small class="fst-italic"><?php echo $meal->description;?></small>
                                                    <a type="button" href="<?php echo APPURL ?>/food/add-cart.php?id=<?php echo $meal->id; ?>" class="btn btn-primary py-2 top-0 end-0 mt-2 me-2">view</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <!-- Tab 3 -->
                        <div id="tab-3" class="tab-pane fade show p-0 <?php echo ($active_tab == 3) ? 'active' : ''; ?>">
                            <div class="row g-4">
                                <?php if ($search !== ''): ?>
                                    <?php if ($active_tab == 3): ?>
                                        <?php foreach($foods as $food): ?>
                                            <?php if($food->meal_id == 3): ?>
                                                <div class="col-lg-6">
                                                    <div class="d-flex align-items-center">
                                                        <img class="flex-shrink-0 img-fluid rounded" src="<?php echo APPIMG;?>/<?php echo $food->image;?>" alt="" style="width: 80px;">
                                                        <div class="w-100 d-flex flex-column text-start ps-4">
                                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                                <span><?php echo $food->name; ?></span>
                                                                <span class="text-primary"><?php echo number_format($food->price); ?> VNĐ</span>
                                                            </h5>
                                                            <small class="fst-italic"><?php echo $food->description;?></small>
                                                            <a type="button" href="<?php echo APPURL ?>/food/add-cart.php?id=<?php echo $food->id; ?>" class="btn btn-primary py-2 top-0 end-0 mt-2 me-2">view</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php foreach($meal_3 as $meal): ?>
                                        <!-- ... hiển thị meal_3 như cũ ... -->
                                            <div class="col-lg-6">
                                                <div class="d-flex align-items-center">
                                                    <img class="flex-shrink-0 img-fluid rounded" src="<?php echo APPIMG;?>/<?php echo $meal->image;?>" alt="" style="width: 80px;">
                                                    <div class="w-100 d-flex flex-column text-start ps-4">
                                                        <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                            <span><?php echo $meal->name; ?></span>
                                                            <span class="text-primary"><?php echo number_format($meal->price); ?> VNĐ</span>
                                                        </h5>
                                                        <small class="fst-italic"><?php echo $meal->description;?></small>
                                                        <a type="button" href="<?php echo APPURL ?>/food/add-cart.php?id=<?php echo $meal->id; ?>" class="btn btn-primary py-2 top-0 end-0 mt-2 me-2">view</a>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                    
        

        <?php require (__DIR__ ."/includes/footer.php"); ?>
