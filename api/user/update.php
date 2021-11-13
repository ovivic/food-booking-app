<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . "/../../config/main.php";

$newUserData = json_decode(file_get_contents("php://input"), true);

$userModel = new UserModel();
$userController = new UserController($userModel);

$responseData = [];

if ($userController->updateUser($newUserData)) {
    $responseData = [
        'status' => APIUtil::UPDATE_SUCCESSFUL,
        'message' => 'User has been updated successfully'
    ];
} else {
    $responseData = [
        'status' => APIUtil::UPDATE_FAIL,
        'message' => 'User has not been updated'
    ];
}

echo json_encode($responseData);