<?php


class UserUtil
{
    public static function generateSaltFromUserProfile(string $userName): string
    {
        return $userName . "_salt";
    }

    public static function addSaltToPassword(string $password, string $salt): string
    {
        return md5($password . $salt);
    }

    public static function validateUserRegistrationFormData($jsonData)
    {
        if (
            !empty($jsonData["name"]) &&
            !empty($jsonData["email"]) &&
            !empty($jsonData["username"]) &&
            !empty($jsonData["password"]) &&
            !empty($jsonData["type"])
        ) {
            return true;
        }

        return false;
    }

    public static function validateUserLoginFormData($jsonData)
    {
        if (!empty($jsonData["username"]) &&
            !empty($jsonData["password"])
        ) {
            return true;
        }

        return false;
    }
}