<?php require (__DIR__ ."/libs/App.php"); ?>
<?php require (__DIR__ ."/includes/header.php"); ?>
<?php require (__DIR__ ."/config/config.php"); ?>


            <div class="container-fluid py-5 bg-dark hero-header mb-5">
                <div class="container text-center my-5 pt-5 pb-4">
                    <h1 class="display-3 text-white mb-3 animated slideInDown">Đặt bàn</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center text-uppercase">
                            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Đặt bàn</li>
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
                        <h5 class="section-title ff-secondary text-start text-primary fw-normal">Đặt bàn</h5>
                        <h1 class="text-white mb-4">Đặt bàn</h1>
                        <form method="POST" action="booking_table.php">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input name="name" class="form-control" id="name" placeholder="Your Name">
                                        <label for="name">Họ và tên</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input name="phone_number" type="phone_number" class="form-control" id="phone_number" placeholder="Số điện thoại">
                                        <label for="phone_number">Số điện thoại</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating date" id="date3" data-target-input="nearest">
                                        <input name="date_booking" type="text" class="form-control datetimepicker-input" id="datetime" placeholder="Date & Time" data-target="#date3" data-toggle="datetimepicker" />
                                        <label for="datetime">Ngày và Giờ</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="num_people" class="form-select" id="select1">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="special_request" class="form-control" placeholder="Special Request" id="message" style="height: 100px"></textarea>
                                        <label for="message">Yêu cầu</label>
                                    </div>
                                </div>
                                <?php if(isset($_SESSION['user_id'])): ?>
                                    <div class="col-12">
                                        <button name="submit" class="btn btn-primary w-100 py-3" type="submit">Đặt Ngay</button>
                                    </div>
                                <?php else: ?>
                                    <div class="col-12">
                                        <a href="<?php echo APPURL;?>/auth/login.php" class="btn btn-primary w-100 py-3">Đăng nhập để đặt bàn</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Reservation Start -->
        

        <?php require (__DIR__ ."/includes/footer.php"); ?>
