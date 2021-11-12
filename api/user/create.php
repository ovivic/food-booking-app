<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . "/../../config/main.php";

$userData = json_decode(file_get_contents("php://input"), true);

$userModel = new UserModel();
$userController = new UserController($userModel);

$responseData = [];

if ($userController->createAction($userData)) {
    $responseData = [
        'status' => UserController::API_CREATE_SUCCESSFUL,
        'message' => 'User has been created successfully'
    ];
} else {
    $responseData = [
        'status' => UserController::API_CREATE_FAIL,
        'message' => 'User has not been created'
    ];
}

echo json_encode($responseData);

