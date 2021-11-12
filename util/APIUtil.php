<?php


class APIUtil
{
    public static function validateUserJson() {

    }

    public static function prepareValueForApi($value) {
        return htmlspecialchars(stripslashes(trim($value)));
    }

    public static function getApiRequest(string $url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, URL_ROOT . $url);

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result, true);
    }

    public static function postApiRequest(string $url, $jsonData) {
        $curl = curl_init(URL_ROOT . $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}