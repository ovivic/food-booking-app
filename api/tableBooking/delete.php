<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . "/../../config/main.php";

// check for deleteID
if (!isset($_GET["tableBookingId"])) {
    echo null;
    exit();
}

$tableBookingId = (isset($_GET["tableBookingId"]) && $_GET["tableBookingId"]) ? $_GET["tableBookingId"] : null;

if ($tableBookingId == null)
{
    echo null;
    exit();
}

$tableBookingModel = new TableBookingModel();
$tableBookingController = new TableBookingController($tableBookingModel);

$responseData = [];

if ($tableBookingController->deleteAction($tableBookingId))
{
    $responseData = [
        'status' => APIUtil::DELETE_SUCCESSFUL,
        'message' => 'Booking has been deleted successfully'
    ];
}
else
{
    $responseData = [
        'status' => APIUtil::DELETE_FAIL,
        'message' => 'Booking has not been deleted'
    ];
}

echo json_encode($responseData);