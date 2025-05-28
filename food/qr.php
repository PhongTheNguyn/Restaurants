<?php

session_start();
require(__DIR__ . "/../libs/App.php");
require(__DIR__ . "/../config/config.php");

$app = new App;

$user_id = $_SESSION["user_id"]; // Lấy user_id từ session
$path = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["name"])) {
    $name = $_POST["name"];
    $phone_number = $_POST["phone_number"];
    $address = $_POST["address"];
    $detail = $_POST["detail"];
    $payment_method = isset($_POST["payment_method"]) ? $_POST["payment_method"] : "ATM";
    $total_price = $app->selectOne("SELECT SUM(price * quantity) AS total FROM cart WHERE user_id = :user_id", [':user_id' => $user_id])->total;
    if ($total_price === null) $total_price = 0;

    // 1. Lưu đơn hàng
    $query = "INSERT INTO orders (name, phone_number, address, detail, total_price, user_id, payment_method) VALUES (:name, :phone_number, :address, :detail, :total_price, :user_id, :payment_method)";
    $arr = [
        ":name" => $name,
        ":phone_number" => $phone_number,
        ":address" => $address,
        ":detail" => $detail,
        ":total_price" => $total_price,
        ":user_id" => $user_id,
        ":payment_method" => $payment_method
    ];
    $order_id = $app->insertAndGetId($query, $arr);

    // 2. Lưu chi tiết đơn hàng
    $cart_items = $app->selectAll("SELECT * FROM cart WHERE user_id = :user_id", [':user_id' => $user_id]);
    foreach ($cart_items as $item) {
        $arrDetail = [
            ':order_id' => $order_id,
            ':food_id' => $item->item_id, // hoặc $item->food_id tùy bảng cart
            ':quantity' => $item->quantity,
            ':price' => $item->price
        ];
        $app->insert(
            "INSERT INTO orders_detail (order_id, food_id, quantity, price) VALUES (:order_id, :food_id, :quantity, :price)",
            $arrDetail,
            null
        );
    }

    $app->insert("DELETE FROM cart WHERE user_id = :user_id", [':user_id' => $user_id], null);


}
?>


<?php

    if(!isset($_SERVER['HTTP_REFERER'])) {
        echo "<script>window.location.href='".APPURL."'</script>";
        exit;
    }
?>


<?php


header('Content-type: text/html; charset=utf-8');


function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}


$endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";


$partnerCode = 'MOMOBKUN20180529';
$accessKey = 'klm05TvNBzhg7h7j';
$secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
$orderInfo = "Thanh toán qua mã QR MoMo";
$amount = $_SESSION["total_price"] ?? 10000;  // Mặc định là 10,000 nếu không có giá trị
$orderId = time() ."";
$redirectUrl = "http://localhost/Restaurants/food/delete_cart.php";
$ipnUrl = "http://localhost/Restaurants/food/delete_cart.php";
$extraData = "";

// Ghi log để debug
error_log("MOMO Payment Request: Amount=$amount, OrderID=$orderId");


$requestId = time() . "";
$requestType = "captureWallet";
// $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
//before sign HMAC SHA256 signature
$rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
$signature = hash_hmac("sha256", $rawHash, $secretKey);
$data = array('partnerCode' => $partnerCode,
    'partnerName' => "Test",
    "storeId" => "MomoTestStore",
    'requestId' => $requestId,
    'amount' => $amount,
    'orderId' => $orderId,
    'orderInfo' => $orderInfo,
    'redirectUrl' => $redirectUrl,
    'ipnUrl' => $ipnUrl,
    'lang' => 'vi',
    'extraData' => $extraData,
    'requestType' => $requestType,
    'signature' => $signature);
$result = execPostRequest($endpoint, json_encode($data));
$jsonResult = json_decode($result, true);  // decode json

//Just a example, please check more in there

header('Location: ' . $jsonResult['payUrl']);
exit;

?>