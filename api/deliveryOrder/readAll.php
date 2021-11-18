<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require __DIR__ . "/../../config/main.php";


$restaurantId = (isset($_GET["restaurantId"]) && $_GET["restaurantId"]) ? $_GET["restaurantId"] : null;
$userId = (isset($_GET["userId"]) && $_GET["userId"]) ? $_GET["userId"] : null;

if ($restaurantId == null && $userId == null)
{
    echo null;
    exit();
}

$deliveryOrderModel = new DeliveryOrderModel();
$deliveryOrderController = new DeliveryOrderController($deliveryOrderModel);

$responseData = [];

$jsonResponse = [];

if ($userId != null)
{
    // get all table bookings for user
    $jsonResponse = $deliveryOrderController->readAllAction("user_id", $userId);
}
elseif ($restaurantId != null)
{
    // get all table bookings for a restaurant
    $jsonResponse = $deliveryOrderController->readAllAction("restaurant_id", $restaurantId);
}


echo $jsonResponse;