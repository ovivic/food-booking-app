<?php


class APIUtil
{
    public static function validateUserJson() {

    }

    public static function getApiResult(string $url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, URL_ROOT . $url);

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result, true);
    }
}