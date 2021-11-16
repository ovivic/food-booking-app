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

var_dump($pageData);

$hasEatIn = $pageData["restaurant"]["delivery"];
$hasDelivery = $pageData["restaurant"]["delivery"];


?>

<!doctype html>
<html lang="en">

<?php include "fragments/siteHeader.php"; ?>

<body>

<?php include "fragments/navbar.php" ?>

<div class="container">
    <h1 class="fd-form-page-heading">Menu Set Up</h1>
    <div class="fd-form-container">

        <p>Press the "Add Item" button to start adding a new item.</p>

    </div>
</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->
<script src="app/user-page-restaurant.js"></script>

</body>
</html>
