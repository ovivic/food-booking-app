<?php


class UserUtil
{
    public static function generateSaltFromProfile(User $user): string
    {
        return $user->getUsername() . "_salt";
    }

    public static function addSaltToPassword(string $password, string $salt): string
    {
        return md5($password . $salt);
    }
}