<?php

// HACK to turn off some notices being thrown by the UserModel
//error_reporting(0);

define("PROJECT_ROOT_PATH", __DIR__ . "/../");
define("PROJECT_FOLDER_NAME", "food-booking-app");
define("URL_ROOT", "http://" . $_SERVER["HTTP_HOST"] . "/" . PROJECT_FOLDER_NAME);

require_once PROJECT_ROOT_PATH . "/config/config.php";

/**
 * Load util classes
 */
require_once PROJECT_ROOT_PATH . "/util/APIUtil.php";
require_once PROJECT_ROOT_PATH . "/util/SiteUtil.php";

/**
 * Load User classes
 */
require_once PROJECT_ROOT_PATH . "/Controller/UserController.php";
require_once PROJECT_ROOT_PATH . "/Model/UserModel.php";
require_once PROJECT_ROOT_PATH . "/Entity/User.php";
require_once PROJECT_ROOT_PATH . "/util/UserUtil.php";

/**
 * Load Restaurant classes
 */
require_once PROJECT_ROOT_PATH . "/Controller/RestaurantController.php";
require_once PROJECT_ROOT_PATH . "/Model/RestaurantModel.php";
require_once PROJECT_ROOT_PATH . "/Entity/Restaurant.php";

/**
 * Load Address classes
 */
require_once PROJECT_ROOT_PATH . "/Controller/AddressController.php";
require_once PROJECT_ROOT_PATH . "/Model/AddressModel.php";
require_once PROJECT_ROOT_PATH . "/Entity/Address.php";