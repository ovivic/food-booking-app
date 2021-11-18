<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . "/../../config/main.php";

// check for deleteID
if (!isset($_GET["deliveryOrderId"])) {
    echo null;
    exit();
}

$deliveryOrderId = (isset($_GET["deliveryOrderId"]) && $_GET["deliveryOrderId"]) ? $_GET["deliveryOrderId"] : null;

if ($deliveryOrderId == null)
{
    echo null;
    exit();
}

$deliveryOrderModel = new DeliveryOrderModel();
$deliveryOrderController = new DeliveryOrderController($deliveryOrderModel);

$responseData = [];

if ($deliveryOrderController->deleteAction($deliveryOrderId))
{
    $responseData = [
        'status' => APIUtil::DELETE_SUCCESSFUL,
        'message' => 'Order has been deleted successfully'
    ];
}
else
{
    $responseData = [
        'status' => APIUtil::DELETE_FAIL,
        'message' => 'Order has not been deleted'
    ];
}

echo json_encode($responseData);