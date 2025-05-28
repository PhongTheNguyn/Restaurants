<?php require (__DIR__ ."/../../libs/App.php"); ?>
<?php require (__DIR__ ."/../layout/header.php"); ?>
<?php require (__DIR__ ."/../../config/config.php"); ?>


<?php
    $query = "SELECT * FROM admins";
    $app = new App;
    $app->validateSessionAdminInside();

    $admins = $app->selectAll($query);

?>
<div class="row center mt-100">
    <div class="col">
        <div class="card ">
            <div class="card-body ">
                <h5 class="card-title mb-4">Admins</h5>
                <a href="create_admin.php" class="btn btn-primary mb-4 text-center ">creat admin</a>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">admin name</th>
                            <th scope="col">email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($admins) && count($admins) > 0): ?>
                            <?php foreach ($admins as $admin): ?>
                            <tr>
                                <td><?php echo $admin->id; ?></td>
                                <th scope="row"><?php echo $admin->admin_name; ?></th>
                                <td><?php echo $admin->email; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center">Không có admin nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php require (__DIR__ ."/../layout/footer.php"); ?>