<?php


class APIUtil
{
    public const CREATE_SUCCESSFUL = 10000;
    public const CREATE_FAIL = 10001;

    public const LOGIN_SUCCESSFUL = 10010;
    public const LOGIN_FAIL = 10011;

    public const UPDATE_SUCCESSFUL = 10100;
    public const UPDATE_FAIL = 10101;

    public const DELETE_SUCCESSFUL = 11000;
    public const DELETE_FAIL = 11001;

    public const MISSING_DATA = 20000;

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

    public static function putApiRequest(string $url, $jsonData) {
        $curl = curl_init(URL_ROOT . $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;

    }

    public static function deleteApiRequest(string $url) {
        var_dump(URL_ROOT . $url);

        $curl = curl_init(URL_ROOT . $url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}