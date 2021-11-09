<?php
define("PROJECT_ROOT_PATH", __DIR__ . "/../");

require_once PROJECT_ROOT_PATH . "/config/config.php";


/**
 * Load User Files
 */
require_once PROJECT_ROOT_PATH . "/Controller/UserController.php";
require_once PROJECT_ROOT_PATH . "/Model/UserModel.php";
require_once PROJECT_ROOT_PATH . "/Entity/User.php";
require_once PROJECT_ROOT_PATH . "/util/UserUtil.php";