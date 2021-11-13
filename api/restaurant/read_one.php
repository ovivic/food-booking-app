<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

require __DIR__ . "/../../config/main.php";

$userId = '';
if (isset($_GET["userId"]) && $_GET["userId"] > 0)
{
    $userId = $_GET["userId"];
}
else
{
    // do not move forward if there is no id present
    // may need to add some other things to happen
    die("Need user ID for read_one API");
}

$restaurantModel = new RestaurantModel();
$restaurantController = new RestaurantController($restaurantModel);

$responseData = [];

if ($userId > 0)
{
    $responseData = $restaurantController->readOneAction($userId);
}

echo json_encode($responseData);