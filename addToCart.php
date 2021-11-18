<?php

session_start();

require 'config/main.php';

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
    header(SiteUtil::ERROR_PAGE . SiteUtil::ERROR_CANNOT_ACCESS);
}


if (!isset($_GET["restaurantId"])) {
    header(SiteUtil::ERROR_PAGE . SiteUtil::ERROR_CANNOT_ACCESS);
}

$restaurantId = $_GET["restaurantId"];
$menuItemData = json_decode($_GET["item"], true);

// create the cart on the session
if (!isset($_SESSION["cart"]))
{
    $_SESSION["cart"] = [
        "restaurantId" => $restaurantId,
        "items" => []
    ];
}

//unset($_SESSION["cart"]);
//die();

// add the item to the cart
if (isset($_SESSION["cart"]["items"][$menuItemData["id"]]))
{
    $_SESSION["cart"]["items"][$menuItemData["id"]]["quantity"] += 1;
}
else
{
    $_SESSION["cart"]["items"][$menuItemData["id"]] = $menuItemData;
    $_SESSION["cart"]["items"][$menuItemData["id"]]["quantity"] = 1;
}

header("Location: viewRestaurant.php?restaurantId=" . $restaurantId);
