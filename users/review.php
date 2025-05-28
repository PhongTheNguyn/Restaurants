<?php require (__DIR__ ."/../libs/App.php"); ?>
<?php require (__DIR__ ."/../config/config.php"); ?>
<?php require (__DIR__ ."/../includes/header.php"); ?>

<?php
    if(isset($_POST["submit"])) {
        $review = $_POST["review"];
        $username = $_SESSION["username"];



        $query = "INSERT INTO reviews (review, username) VALUES (:review, :username)";
        $arr = [
            ":review" => $review,
            ":username"=> $username,
        ];

        $path = "bookings.php";


        $app->insert( query: $query, arr: $arr, path: $path); 
    }      

?>


            <div class="container-fluid py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Đánh giá</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Đánh giá</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Navbar & Hero End -->


        <!-- Reservation Start -->
        <div class="container-xxl py-5 px-0 wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-0">
                <div class="col-md-6">
                    <img src="./img/video.jpg" class="h-100" alt="">
                </div>
                <div class="col-md-6 bg-dark d-flex align-items-center">
                <div class="p-5 wow fadeInUp" data-wow-delay="0.2s">
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Đánh giá</h5>
                        <h1 class="text-white mb-4">Đánh giá</h1>
                        <form method="POST" action="review.php">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="review" class="form-control" placeholder="Viết đánh giá" id="message" style="height: 100px"></textarea>
                                        <label for="message">Viết đánh giá</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button name="submit" class="btn btn-primary w-100 py-3" type="submit">Đăng</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    
        <!-- Reservation Start -->
        

        <?php require (__DIR__ ."/../includes/footer.php"); ?>
