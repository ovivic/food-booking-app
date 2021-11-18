<?php

session_start();

require 'config/main.php';

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
    header(SiteUtil::ERROR_PAGE . SiteUtil::ERROR_CANNOT_ACCESS);
}


if (!isset($_GET["itemId"])) {
    header(SiteUtil::ERROR_PAGE . SiteUtil::ERROR_CANNOT_ACCESS);
}

$itemId = $_GET["itemId"];

if (isset($_SESSION["cart"]["items"][$itemId]))
{
    $_SESSION["cart"]["items"][$itemId]["quantity"] -= 1;

    if ($_SESSION["cart"]["items"][$itemId]["quantity"] <= 0)
    {
        unset($_SESSION["cart"]["items"][$itemId]);
    }
}

header("Location: orderCart.php");