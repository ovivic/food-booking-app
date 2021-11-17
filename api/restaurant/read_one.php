<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

require __DIR__ . "/../../config/main.php";

$userId = null;
if (isset($_GET["userId"]) && $_GET["userId"] > 0)
{
    $userId = $_GET["userId"];
}

$restaurantId = null;
if (isset($_GET["restaurantId"]) && $_GET["restaurantId"] > 0)
{
    $restaurantId = $_GET["restaurantId"];
}

$restaurantModel = new RestaurantModel();
$restaurantController = new RestaurantController($restaurantModel);

$responseData = [];

if ($userId !== null && $userId > 0)
{
    $responseData = $restaurantController->readOneAction($userId);
}

if ($restaurantId !== null && $restaurantId > 0)
{
    $responseData = $restaurantController->readByRestaurantId($restaurantId);
}

echo json_encode($responseData);