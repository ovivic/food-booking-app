<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . "/../../config/main.php";

$restaurantData = json_decode(file_get_contents("php://input"), true);

$restaurantModel = new RestaurantModel();
$restaurantController = new RestaurantController($restaurantModel);

$responseData = [];

$restID = $restaurantController->createAction($restaurantData);

if ($restID) {
    $responseData = [
        'status' => APIUtil::CREATE_SUCCESSFUL,
        'id' => $restID,
        'message' => 'Restaurant has been created successfully'
    ];
} else {
    $responseData = [
        'status' => APIUtil::CREATE_FAIL,
        'message' => 'Restaurant has not been created'
    ];
}

echo json_encode($responseData);
