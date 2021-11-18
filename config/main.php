<?php

// HACK to turn off some notices being thrown by the UserModel which cause the API return to fail
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

/**
 * Load MenuItem classes
 */
require_once PROJECT_ROOT_PATH . "/Controller/MenuItemController.php";
require_once PROJECT_ROOT_PATH . "/Model/MenuItemModel.php";
require_once PROJECT_ROOT_PATH . "/Entity/MenuItem.php";

/**
 * Load RestaurantTable classes
 */
require_once PROJECT_ROOT_PATH . "/Controller/RestaurantTableController.php";
require_once PROJECT_ROOT_PATH . "/Model/RestaurantTableModel.php";
require_once PROJECT_ROOT_PATH . "/Entity/RestaurantTable.php";

/**
 * Load TableBooking classes
 */
require_once PROJECT_ROOT_PATH . "/Controller/TableBookingController.php";
require_once PROJECT_ROOT_PATH . "/Model/TableBookingModel.php";
require_once PROJECT_ROOT_PATH . "/Entity/TableBooking.php";

/**
 * Load DeliveryOrder classes
 */
require_once PROJECT_ROOT_PATH . "/Controller/DeliveryOrderController.php";
require_once PROJECT_ROOT_PATH . "/Model/DeliveryOrderModel.php";
require_once PROJECT_ROOT_PATH . "/Entity/DeliveryOrder.php";