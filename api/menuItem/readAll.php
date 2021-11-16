<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require __DIR__ . "/../../config/main.php";


if (!isset($_GET["restaurantId"]))
{
    echo null;
    exit();
}

$restaurantId = (isset($_GET["restaurantId"]) && $_GET["restaurantId"]) ? $_GET["restaurantId"] : null;

if ($restaurantId == null)
{
    echo null;
    exit();
}

$menuItemModel = new MenuItemModel();
$menuItemController = new MenuItemController($menuItemModel);

$jsonResponse = [];

$jsonResponse = $menuItemController->readAllAction($restaurantId);

echo $jsonResponse;
