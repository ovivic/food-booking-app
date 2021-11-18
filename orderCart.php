<?php

require 'config/main.php';

session_start();


$userLoggedIn = false;
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
    $userLoggedIn = true;
}


$pageData = [];

// get restaurantData
$restaurantResponse = json_decode(APIUtil::getApiRequest(RestaurantController::API_READ_ONE . "?restaurantId=" . $_SESSION["cart"]["restaurantId"]), true);

if (isset($restaurantResponse["records"]))
{
    $pageData["restaurant"] = $restaurantResponse["records"][0];
}

// get restaurant Address data
$restAddressResponse = APIUtil::getApiRequest(AddressController::API_READ_ONE . "?entityId=" . $_SESSION["cart"]["restaurantId"] . "&forRestaurant=true");

if (isset($restAddressResponse["records"]))
{
    $pageData["restAddress"] = $restAddressResponse["records"][0];
}

$cartTotal = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cartFormType"]))
{
    if ($_POST["cartFormType"] == SiteUtil::CART_PAGE_REMOVE_ITEM) {
        $itemId = $_POST["itemId"];

        header("Location: removeFromCart.php?itemId=" . $itemId);
    }
}

?>

<!doctype html>
<html lang="en">

<?php include "fragments/siteHeader.php"; ?>

<body>

<?php include "fragments/navbar.php" ?>

<div class="container">

    <h1 class="fd-rest-page-heading"><?php echo $pageData["restaurant"]["name"]; ?> Order</h1>
    <p class="fd-rest-page-subheading"><?php echo isset($pageData["restAddress"]) ? $pageData["restAddress"]["addressString"] : '' ?></p>
    <div class="fd-form-container">

        <div class="d-flex justify-content-between mb-3">
            <p>PLease view your cart below. Here you can remove any unwanted items.</p>
            <a href="viewRestaurant.php?restaurantId=<?php echo $pageData["restaurant"]["id"] ?>" class="btn fd-button">Back To Restaurant Page</a>
        </div>
        
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Item Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php
                $counter = 1;
                foreach ($_SESSION["cart"]["items"] as $item)
                {
                    $tableRow = "<tr><th scope=\"row\">" . $counter . "</th>";

                    $tableRow .= "<td>" . $item["name"] . "</td>";
                    $tableRow .= "<td>" . $item["quantity"] . "</td>";
                    $tableRow .= "<td>" . SiteUtil::formatCurrency($item["price"]) . "</td>";

                    $deleteForm = "<form class='fd-menu-item-delete-form' method='POST' action='orderCart.php'>";
                    $deleteForm .= "<input type='hidden' name='cartFormType' value='" . SiteUtil::CART_PAGE_REMOVE_ITEM . "'>";
                    $deleteForm .= "<input type='hidden' name='itemId' value='" . $item["id"] . "'>";
                    $deleteForm .= "<button type='submit'  class='btn fd-button'>Remove</button>";
                    $deleteForm .= "</form>";

                    $tableRow .= "<td>" . $deleteForm . "</td>";

                    $tableRow .= "</tr>";

                    $counter += 1;

                    $cartTotal += $item["quantity"] * $item["price"];

                    echo $tableRow;
                }
            ?>
            <tr>
                <th colspan="3" class="text-right">Order Total:</th>
                <td><?php echo SiteUtil::formatCurrency($cartTotal) ?></td>
            </tr>
            </tbody>
        </table>

        <div class="fd-section-delim"></div>

        <div class="d-flex justify-content-between mb-3">
            <h3>Your Details</h3>
            <form action="orderCart.php" method="post">
                <button type="submit" class="btn fd-button">Send Order</button>
            </form>
        </div>

        <div class="fd-user-detail-container">
            <p><span>Name: </span><?php echo SiteUtil::getUserInfoFromSession("name"); ?></p>
        </div>
        <div class="fd-user-detail-container">
            <p><span>Email: </span><?php echo SiteUtil::getUserInfoFromSession("email"); ?></p>
        </div>
        <div class="fd-user-detail-container">
            <p><span>Address: </span><?php echo SiteUtil::getUserInfoFromSession("address"); ?></p>
        </div>

    </div>

</div>


<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->

</body>
</html>

