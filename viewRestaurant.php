<?php

require 'config/main.php';

session_start();

function getMenuItemDiv($menuItem)
{
    return '
        <div class="d-flex justify-content-between fd-rest-page-menu-item">
            <p style="font-weight: bold">' . $menuItem["name"] . '</p>
            <p> ' . SiteUtil::formatCurrency($menuItem["price"]) . ' </p>
        </div>
    ';
}

$restaurantId = null;

if (isset($_GET["restaurantId"]) && $_GET["restaurantId"])
{
    $restaurantId = $_GET["restaurantId"];
}

// redirect ot error
if ($restaurantId == 0 || $restaurantId == null)
{
    header(SiteUtil::ERROR_PAGE . SiteUtil::ERROR_NO_RESTAURANT);
}

$pageData = [];

// get restaurantData
$restaurantResponse = json_decode(APIUtil::getApiRequest(RestaurantController::API_READ_ONE . "?restaurantId=" . $restaurantId), true);

if (isset($restaurantResponse["records"]))
{
    $pageData["restaurant"] = $restaurantResponse["records"][0];
}

// get restaurant Address data
$restAddressResponse = APIUtil::getApiRequest(AddressController::API_READ_ONE . "?entityId=" . $restaurantId . "&forRestaurant=true");

if (isset($restAddressResponse["records"]))
{
    $pageData["restAddress"] = $restAddressResponse["records"][0];
}

// get restaurant menu
$menuResponse = APIUtil::getApiRequest(MenuItemController::API_READ_ALL . "?restaurantId=" . $pageData["restaurant"]["id"]);

if (isset($menuResponse["records"])) {
    $pageData["menu"] = $menuResponse["records"];
}

// get restaurant Tables
if ($pageData["restaurant"]["dine_in"])
{
    $restTableData = APIUtil::getApiRequest(RestaurantTableController::API_READ_ALL . "?restaurantId=" . $pageData["restaurant"]["id"]);

    if (isset($restTableData["records"])) {
        $pageData["restaurantTables"] = $restTableData["records"];
    }
}

var_dump($pageData);

?>

<!doctype html>
<html lang="en">

<?php include "fragments/siteHeader.php"; ?>

<body>

<?php include "fragments/navbar.php" ?>

<div class="container">

    <div class="container">

        <h1 class="fd-rest-page-heading"><?php echo $pageData["restaurant"]["name"]; ?></h1>
        <p class="fd-rest-page-subheading"><?php echo isset($pageData["restAddress"]) ? $pageData["restAddress"]["addressString"] : '' ?></p>
        <div class="fd-form-container">
            <div class="row">
                <div class="col">
                    <h3>Contact</h3>
                    <div class="fd-user-detail-container">
                        <p><span>Email: </span><?php echo $pageData["restaurant"]["email"]; ?></p>
                    </div>
                    <div class="fd-user-detail-container">
                        <p><span>Phone: </span><?php echo $pageData["restaurant"]["phone"]; ?></p>
                    </div>
                    <div class="fd-user-detail-container">
                        <p><span>Address: </span><?php echo $pageData["restAddress"]["addressString"]; ?></p>
                    </div>
                </div>

                <div class="col">
                    <h3>Description</h3>
                    <p><?php echo $pageData["restaurant"]["description"]; ?></p>
                </div>
            </div>

            <div class="fd-section-delim"></div>

            <h3>Menu</h3>
            <p>Please find bellow the menu. Click on an item to add it to the cart for delivery.</p>

            <?php

                foreach ($pageData["menu"] as $menuItem)
                {
                    echo getMenuItemDiv($menuItem);
                }

            ?>

        </div>
    </div>

</div>


<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->

</body>
</html>

