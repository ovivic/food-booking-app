<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . "/../../config/main.php";

$deliveryOrderData = json_decode(file_get_contents("php://input"), true);

$deliveryOrderModel = new DeliveryOrderModel();
$deliveryOrderController = new DeliveryOrderController($deliveryOrderModel);

$responseData = [];

if ($deliveryOrderController->createAction($deliveryOrderData)) {
    $responseData = [
        'status' => APIUtil::CREATE_SUCCESSFUL,
        'message' => 'Order has been created successfully'
    ];
} else {
    $responseData = [
        'status' => APIUtil::CREATE_FAIL,
        'message' => 'Order has not been created'
    ];
}

echo json_encode($responseData);
