<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require __DIR__ . "/../../config/main.php";

$restaurantModel = new RestaurantModel();
$restaurantController = new RestaurantController($restaurantModel);

// create the json response
$jsonResponse = [];

$jsonResponse = $restaurantController->listAction();

echo $jsonResponse;
