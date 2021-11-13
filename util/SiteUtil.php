<?php


class SiteUtil
{
    public const USER_PAGE_PASSWORD_RESET_FORM = 10;
    public const USER_PAGE_ADDRESS_FORM = 11;

    public static function getUserInfoFromSession(string $field) {
        if (isset($_SESSION["userData"][$field]) && !empty($_SESSION["userData"][$field])) {
            return $_SESSION["userData"][$field];
        }

        return null;
    }

}