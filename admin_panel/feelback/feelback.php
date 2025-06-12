
<?php
require(__DIR__ . "/../../libs/App.php");
require(__DIR__ . "/../layout/header.php");
require(__DIR__ . "/../../config/config.php");

$app = new App;

// Xử lý tìm kiếm
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search !== '') {
    $feedbacks = $app->selectAll(
        "SELECT * FROM feedback WHERE user_name LIKE :kw OR email LIKE :kw ORDER BY created_at DESC",
        [':kw' => '%' . $search . '%']
    );
} else {
    $feedbacks = $app->selectAll("SELECT * FROM feedback ORDER BY created_at DESC");
}
?>

<div class="container mt-100">
    <h2 class="mb-4">Danh sách phản hồi khách hàng</h2>
    <form method="GET" action="feelback.php" class="mb-3">
        <div class="input-group" style="max-width:400px;">
            <input type="text" class="form-control" name="search" placeholder="Tìm theo tên hoặc email..." value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-primary" type="submit">Tìm kiếm</button>
        </div>
    </form>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên khách hàng</th>
                <th>Email</th>
                <th>Nội dung</th>
                <th>Thời gian gửi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($feedbacks)): ?>
                <?php foreach ($feedbacks as $fb): ?>
                    <tr>
                        <td><?php echo $fb->id; ?></td>
                        <td><?php echo htmlspecialchars($fb->user_name); ?></td>
                        <td><?php echo htmlspecialchars($fb->email); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($fb->message)); ?></td>
                        <td><?php echo $fb->created_at; ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Chưa có phản hồi nào.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require(__DIR__ . "/../layout/footer.php"); ?>