<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

require __DIR__ . "/../../config/main.php";

// check if there is a limit argument passed
$userId = 0;
if (isset($_GET["id"]) && $_GET["id"] > 0)
{
    $userId = $_GET["id"];
}
else
{
    // do not move forward if there is no id present
    // may need to add some other things to happen
    die("Not ID for read_one API");
}

$userModel = new UserModel();
$userController = new UserController($userModel);

// create the json response
$jsonResponse = [];

if ($userId > 0)
{
    $jsonResponse = $userController->readOneAction($userId);
}

echo $jsonResponse;
