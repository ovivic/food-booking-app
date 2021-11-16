<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . "/../../config/main.php";

// check for deleteID
if (!isset($_GET["restTableId"])) {
    echo null;
    exit();
}

$restTableId = (isset($_GET["restTableId"]) && $_GET["restTableId"]) ? $_GET["restTableId"] : null;

if ($restTableId == null)
{
    echo null;
    exit();
}

$restaurantTableModel = new RestaurantTableModel();
$restaurantTableController = new RestaurantTableController($restaurantTableModel);

$responseData = [];

if ($restaurantTableController->deleteAction($restTableId))
{
    $responseData = [
        'status' => APIUtil::DELETE_SUCCESSFUL,
        'message' => 'Restaurant Table has been deleted successfully'
    ];
}
else
{
    $responseData = [
        'status' => APIUtil::DELETE_FAIL,
        'message' => 'Restaurant Table has not been deleted'
    ];
}

echo json_encode($responseData);
