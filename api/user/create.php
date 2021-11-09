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

if ($userController->createAction($userData)) {
    echo "User created";
} else {
    echo "User NOT created";
}

