<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . "/../../config/main.php";

// check for deleteID
if (!isset($_GET["menuItemId"])) {
    echo null;
    exit();
}

$menuItemId = (isset($_GET["menuItemId"]) && $_GET["menuItemId"]) ? $_GET["menuItemId"] : null;

if ($menuItemId == null)
{
    echo null;
    exit();
}

$menuItemModel = new MenuItemModel();
$menuItemController = new MenuItemController($menuItemModel);

$responseData = [];

if ($menuItemController->deleteAction($menuItemId))
{
    $responseData = [
        'status' => APIUtil::DELETE_SUCCESSFUL,
        'message' => 'Menu Item has been deleted successfully'
    ];
}
else
{
    $responseData = [
        'status' => APIUtil::DELETE_FAIL,
        'message' => 'Menu Item has not been deleted'
    ];
}

echo json_encode($responseData);
