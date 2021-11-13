<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

require __DIR__ . "/../../config/main.php";

$entityId = '';
if (isset($_GET["entityId"]) && $_GET["entityId"] > 0)
{
    $entityId = $_GET["entityId"];
}
else
{
    // do not move forward if there is no id present
    // may need to add some other things to happen
    die("Need ID for read_one API");
}

$isForRestaurant = false;
if (isset($_GET["forRestaurant"])) {
    $isForRestaurant = true;
}

$addressModel = new AddressModel();
$addressController = new AddressController($addressModel);

$formData = [];

if ($entityId > 0)
{
    if ($isForRestaurant) {
        $formData = $addressController->readOneAction($entityId, $isForRestaurant); // get restaurant address
    } else {
        $formData = $addressController->readOneAction($entityId); // get client address
    }
}

echo $formData;
