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

$tableBookingModel = new TableBookingModel();
$tableBookingController = new TableBookingController($tableBookingModel);

$jsonResponse = [];

if ($userId != null)
{
    // get all table bookings for user
    $jsonResponse = $tableBookingController->readAllAction("user_id", $userId);
}
elseif ($restaurantId != null)
{
    // get all table bookings for a restaurant
    $jsonResponse = $tableBookingController->readAllAction("restaurant_id", $restaurantId);
}


echo $jsonResponse;