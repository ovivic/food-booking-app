<?php

require 'config/main.php';

session_start();

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
    header("Location: login.php?showNotLoggedInMessage=1");
}

// if accessed by client user redirect to error page
if (SiteUtil::getUserInfoFromSession("type") === User::CLIENT_TYPE) {
    header(SiteUtil::ERROR_PAGE . SiteUtil::ERROR_CANNOT_ACCESS);
}


// get the restaurant record associated with the account
$restaurantData = json_decode(APIUtil::getApiRequest(RestaurantController::API_READ_ONE . "?userId=" . SiteUtil::getUserInfoFromSession("id")), true);

$pageData = [];

if (isset($restaurantData["records"])) {
    $pageData["restaurant"] = $restaurantData["records"][0];
} else {
    header(SiteUtil::ERROR_PAGE . SiteUtil::ERROR_NO_RESTAURANT);
}

$menuItemData = APIUtil::getApiRequest(MenuItemController::API_READ_ALL . "?restaurantId=" . $pageData["restaurant"]["id"]);

if (isset($menuItemData["records"])) {
    $pageData["menuItems"] = $menuItemData["records"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["restMenuFormType"])) {
    if ($_POST["restMenuFormType"] == SiteUtil::RESTAURANT_MENU_PAGE_DELETE_ITEM) {

        $menuItemId = $_POST["menuItemId"];

        $itemDeleteResponse = json_decode(APIUtil::deleteApiRequest(MenuItemController::API_DELETE . "?menuItemId=" . $menuItemId), true);

        // redirect to this page to reload page data
        if ($itemDeleteResponse["status"] == APIUtil::DELETE_SUCCESSFUL) {
            header("Location: restaurantMenu.php");
        }
    }

    if ($_POST["restMenuFormType"] == SiteUtil::RESTAURANT_MENU_PAGE_ADD_ITEM) {

    }

}


?>

<!doctype html>
<html lang="en">

<?php include "fragments/siteHeader.php"; ?>

<body>

<?php include "fragments/navbar.php" ?>

<div class="container">
    <h1 class="fd-form-page-heading">Menu Set Up</h1>
    <div class="fd-form-container">

        <div class="d-flex justify-content-between mb-3">
            <p>Complete the form to add an item. After adding it will appear in the table bellow.</p>
            <a class="btn fd-button" href="userPageRestaurant.php">Restaurant Page</a>
        </div>

        <form action="restaurantMenu.php" method="post">
            <input type='hidden' name='restMenuFormType' value='<?php SiteUtil::RESTAURANT_MENU_PAGE_ADD_ITEM ?>'>

            <div class="form-row align-items-center mb-2">
                <div class="col-auto">
                    <input type="text" class="form-control" name="menuItemName" placeholder="Item Name" required>
                </div>

                <div class="col-auto">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">&pound;</div>
                        </div>
                        <input type="text" class="form-control" name="menuItemPrice" placeholder="Item Price" required>
                    </div>
                </div>

                <div class="col-auto">
                    <button type='submit' id='menu-item-add' class='btn fd-button'>Add Item</button>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Item Price</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $counter = 1;
                    foreach ($pageData["menuItems"] as $menuItem) {
                        $tableRow = "<tr><th scope=\"row\">" . $counter . "</th>";

                        $tableRow .= "<td>" . $menuItem["name"] . "</td>";
                        $tableRow .= "<td>" . SiteUtil::formatCurrency($menuItem["price"]) . "</td>";

                        $deleteForm = "<form class='fd-menu-item-delete-form' method='POST' action='restaurantMenu.php'>";
                        $deleteForm .= "<input type='hidden' name='restMenuFormType' value='" . SiteUtil::RESTAURANT_MENU_PAGE_DELETE_ITEM . "'>";
                        $deleteForm .= "<input type='hidden' name='menuItemId' value='" . $menuItem["id"] . "'>";
                        $deleteForm .= "<button type='submit' id='menu-item-delete" . $counter . "' class='btn fd-button'>Delete</button>";
                        $deleteForm .= "</form>";

                        $tableRow .= "<td>" . $deleteForm . "</td>";

                        echo $tableRow;

                        $counter += 1;
                    }
                ?>
            </tbody>
        </table>

    </div>
</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->
<script src="app/restaurant-menu.js"></script>

</body>
</html>
