<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require __DIR__ . "/../../config/main.php";

// TODO: add security to the api so that it cannot be accessed if the user is not logged in

// check if there is a limit argument passed
$limit = 0;
if (isset($_GET["limit"]) && $_GET["limit"] > 0)
{
    $limit = $_GET["limit"];
}

$userModel = new UserModel();
$userController = new UserController($userModel);

// create the json response
$jsonResponse = [];

if ($limit > 0)
{
    $jsonResponse = $userController->listAction($limit);
}
else
{
    $jsonResponse = $userController->listAction();
}

echo $jsonResponse;