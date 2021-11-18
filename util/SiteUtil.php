<?php


class SiteUtil
{
    public const USER_PAGE_PASSWORD_RESET_FORM = 10;
    public const USER_PAGE_ADDRESS_FORM = 11;
    public const USER_PAGE_RESTAURANT_FORM = 12;

    public const RESTAURANT_MENU_PAGE_DELETE_ITEM = 10;
    public const RESTAURANT_MENU_PAGE_ADD_ITEM = 11;

    public const RESTAURANT_TABLES_PAGE_DELETE_TABLE = 10;
    public const RESTAURANT_TABLES_PAGE_ADD_TABLE = 11;

    public const RESTAURANT_VIEW_PAGE_ADD_BOOKING = 10;

    public const TABLE_BOOKING_PAGE_DELETE = 10;

    /* ERROR PAGE */
    public const ERROR_CANNOT_ACCESS = 1;
    public const ERROR_NO_RESTAURANT = 2;

    public const ERROR_NOT_DINE_IN = 3;

    public const ERROR_PAGE = "Location: errorPage.php?errorType=";

    public static function getUserInfoFromSession(string $field) {
        if (isset($_SESSION["userData"][$field]) && !empty($_SESSION["userData"][$field])) {
            return $_SESSION["userData"][$field];
        }

        return null;
    }

    public static function formatCurrency($value)  {
        return "&pound;" . number_format($value, 2);
    }

}