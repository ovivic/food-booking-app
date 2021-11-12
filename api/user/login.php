<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . "/../../config/main.php";

$userData = json_decode(file_get_contents("php://input"), true);

// verifies if the user login credentials are good
$userModel = new UserModel();
$userController = new UserController($userModel);

$responseData = [];

$user = $userController->canLogin($userData);

if ($user !== null) {
    $responseData = [
        'status' => APIUtil::LOGIN_SUCCESSFUL,
        'message' => 'User can log in',
        'user' => $user->getSerialization()
    ];
} else {
    $responseData = [
        'status' => APIUtil::LOGIN_FAIL,
        'message' => 'User cannot log in'
    ];
}

echo json_encode($responseData);
