<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . "/../../config/main.php";

$restaurantData = json_decode(file_get_contents("php://input"), true);

$restaurantModel = new RestaurantModel();
$restaurantController = new RestaurantController($restaurantModel);

if ($restaurantController->updateAction($restaurantData)) {
    $responseData = [
        'status' => APIUtil::UPDATE_SUCCESSFUL,
        'message' => 'Restaurant has been created successfully'
    ];
} else {
    $responseData = [
        'status' => APIUtil::UPDATE_FAIL,
        'message' => 'Restaurant has not been created'
    ];
}

echo json_encode($responseData);
