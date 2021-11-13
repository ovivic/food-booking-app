<?php


class SiteUtil
{
    public static function getUserInfoFromSession(string $field) {
        if (isset($_SESSION["userData"][$field]) && !empty($_SESSION["userData"][$field])) {
            return $_SESSION["userData"][$field];
        }

        return null;
    }

}