<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require __DIR__ . "/../../config/main.php";

$addressData = json_decode(file_get_contents("php://input"), true);

$addressModel = new AddressModel();
$addressController = new AddressController($addressModel);

$responseData = [];

if ($addressController->createAction($addressData)) {
    $responseData = [
        'status' => APIUtil::CREATE_SUCCESSFUL,
        'message' => 'Address has been created successfully'
    ];
} else {
    $responseData = [
        'status' => APIUtil::CREATE_FAIL,
        'message' => 'Address has not been created'
    ];
}

echo json_encode($responseData);


