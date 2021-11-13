<?php

require 'config/main.php';

session_start();

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
    header("Location: login.php?showNotLoggedInMessage=1");
}

// get user's restaurant and address records
$restaurantData = json_decode(APIUtil::getApiRequest(RestaurantController::API_READ_ONE . "?userId=" . SiteUtil::getUserInfoFromSession("id")), true);

$restaurantID = $restaurantData["records"][0]["id"];
$restaurantAddress = APIUtil::getApiRequest(AddressController::API_READ_ONE . "?entityId=" . $restaurantID . "&forRestaurant=1");

$pageData = [
    "restaurant" => $restaurantData,
    "restAddress" => $restaurantAddress
];

//var_dump($pageData);

// password change form
$password = '';
$isErrorPassChange = false;
$isPasswordFormValid = false;
$passwordUpdatedStatus = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userPageFormType"])) {
    if ($_POST["userPageFormType"] == SiteUtil::USER_PAGE_PASSWORD_RESET_FORM) // the password reset form was submitted
    {
        if (empty($_POST["password"])) {
            $passwordErr = "Password cannot be empty";
            $isErrorPassChange = true;
        } else {
            $password = APIUtil::prepareValueForApi($_POST["password"]);

            if (strlen($password) < 8 || strlen($password) > 16) {
                $passwordErr = "Must be between 8 and 16 characters";
                $isErrorPassChange = true;
            }
        }

        if (empty($_POST["confirm-password"])) {
            $confirmPasswordError = "The password confirmation cannot be empty";
            $isErrorPassChange = true;
        } else {
            $confirmPassword = APIUtil::prepareValueForApi($_POST["confirm-password"]);

            if ($confirmPassword != $password) {
                $confirmPasswordError = "The passwords do not match";
                $isErrorPassChange = true;
            }
        }

        if (!$isErrorPassChange) {
            $isPasswordFormValid = true;

            $passwordFormData = [
                "id" => SiteUtil::getUserInfoFromSession("id"),
                "password" => $password
            ];

            $passwordRequestResponse = json_decode(APIUtil::putApiRequest(UserController::API_UPDATE, json_encode($passwordFormData)), true);

            if ($passwordRequestResponse["status"] == APIUtil::UPDATE_SUCCESSFUL) {
                $passwordUpdatedStatus = true;
            } elseif ($passwordRequestResponse["status"] == APIUtil::UPDATE_FAIL) {
                $passwordUpdatedStatus = false;
            }
        }
    }

    if ($_POST["userPageFormType"] == SiteUtil::USER_PAGE_RESTAURANT_FORM) // the restaurant form was submitted
    {

    }
}

?>

<!doctype html>
<html lang="en">

<?php include "fragments/siteHeader.php"; ?>

<body>

<?php include "fragments/navbar.php" ?>

<div class="container">

</div>

<div class="container">
    <h1 class="fd-form-page-heading">Account Details</h1>
    <div class="fd-form-container">
        <h3>Personal Details</h3>
        <div class="fd-user-detail-container">
            <p><span>Name: </span><?php echo SiteUtil::getUserInfoFromSession("name"); ?></p>
        </div>
        <div class="fd-user-detail-container">
            <p><span>Email: </span><?php echo SiteUtil::getUserInfoFromSession("email"); ?></p>
        </div>

        <div class="fd-section-delim"></div>

        <h3>Account Details</h3>
        <div class="fd-user-detail-container">
            <p><span>Username: </span><?php echo SiteUtil::getUserInfoFromSession("username"); ?></p>
        </div>

        <?php if ($isPasswordFormValid && $passwordUpdatedStatus == true) { ?>
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle"></i> Your password has been updated successfully.
            </div>
        <?php } elseif ($isPasswordFormValid && $passwordUpdatedStatus == false) { ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-x-circle"></i> There has been a problem when trying to update your password.
            </div>
        <?php } ?>

        <form id="password-reset-form" action="userPageRestaurant.php" method="POST">
            <div class="form-group">
                <label for="password">Reset Password</label>
                <input type="password" class="form-control fd-form-" name="password" id="password" placeholder="New Password" required>
                <?php
                if (!empty($passwordErr)) {
                    echo '<small id="passwordError" class="form-text text-muted fd-form-text-error">' . $passwordErr . '</small>';
                }
                ?>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm password</label>
                <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Confirm Password" required>
                <?php
                if (!empty($confirmPasswordError)) {
                    echo '<small id="confirmPasswordError" class="form-text text-muted fd-form-text-error">' . $confirmPasswordError . '</small>';
                }
                ?>
            </div>

            <input type="hidden" name="userPageFormType" value="<?php echo SiteUtil::USER_PAGE_PASSWORD_RESET_FORM ?>">

            <button type="submit" class="btn fd-button">Reset Password</button>
        </form>
    </div>

    <h1 class="fd-form-page-heading">Restaurant</h1>
    <div class="fd-form-container">

    </div>
</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->

</body>
</html>
