<?php require (__DIR__ ."/../../libs/App.php"); ?>
<?php require (__DIR__ ."/../layout/header.php"); ?>
<?php require (__DIR__ ."/../../config/config.php"); ?>

<?php



    $app = new App;
    $app->validateSessionAdminInside();


    if(isset($_POST["submit"])) {
        $admin_name = $_POST["admin_name"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $query = "INSERT INTO admins (admin_name, email, password) VALUES (:admin_name, :email, :password)";
        $arr = [
            ":admin_name" => $admin_name,
            ":email"=> $email,
            ":password"=> $password,
        ];

        $path = "admin.php";


        $app->register( query: $query, arr: $arr, path: $path); 
    }

?>




<div class="row center mt-100">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-5 d-inline">Create Admin</h5>
                <form action="create_admin.php" method="POST" enctype="multipart/form-data">
                    <div class="form-outline mb-4">
                        <input type="text" class="form-control" id="form2Example1" placeholder="Admin Name" name="admin_name" required>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="email" class="form-control" id="form2Example1" placeholder="Email" name="email" required>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="password" class="form-control" id="form2Example1" placeholder="Password" name="password" required>
                    </div>
                    <button name="submit" type="submit" class="btn btn-primary">Create</button>
                </form>
                
            </div>
        </div>
    </div>
</div>

<?php require (__DIR__ ."/../layout/footer.php"); ?>
