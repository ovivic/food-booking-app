<?php

require 'config/main.php';

session_start();

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
    header("Location: login.php?showNotLoggedInMessage=1");
}

// get user's restaurant and address records
$restaurantData = json_decode(APIUtil::getApiRequest(RestaurantController::API_READ_ONE . "?userId=" . SiteUtil::getUserInfoFromSession("id")), true);

// need null check for both the rest and the address
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

// restaurant update form
$restName = $restEmail = $restPhone = $restDesc = $restStreet = $restTown = $restCounty = $restPostCode = '';
$restEatIn = $restDeliv = false;

$restNameErr = $restEmailErr = $restPhoneErr = '';
$restStreetErr = $restTownErr = $restPostCodeErr = false;

$isErrorRest = false;
$isRestFormValid = false;
$restUpdateStatus = false;


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
        if (empty($_POST["rest-name"])) {
            $restNameErr = "Restaurant name cannot be empty";
            $isErrorRest = true;
        } else {
            $restName = APIUtil::prepareValueForApi($_POST["rest-name"]);
        }

        if (empty($_POST["rest-email"])) {
            $restEmailErr = "Email address is required";
            $isErrorRest = true;
        } else {
            $restEmail = APIUtil::prepareValueForApi($_POST["rest-email"]);

            if (!filter_var($restEmail, FILTER_VALIDATE_EMAIL)) {
                $restEmailErr = "Invalid email format";
                $isErrorRest = true;
            }
        }

        if (empty($_POST["rest-phone"])) {
            $restNameErr = "The phone number cannot be empty";
            $isErrorRest = true;
        } else {
            $restName = APIUtil::prepareValueForApi($_POST["rest-phone"]);
        }

        if (!empty($_POST["rest-description"])) {
            $restDesc = APIUtil::prepareValueForApi($_POST["rest-description"]);
        }

        if (!empty($_POST["rest-dine-in"]) && $_POST["rest-dine-in"] == Restaurant::DINE_IN) {
            $restEatIn = true;
        }

        if (!empty($_POST["rest-delivery"]) && $_POST["rest-delivery"] == Restaurant::DELIVERY) {
            $restDeliv = true;
        }

        if (empty($_POST["rest-street"])) {
            $restStreetErr = true;
            $isErrorRest = true;
        } else {
            $restStreet = APIUtil::prepareValueForApi($_POST["rest-street"]);
        }

        if (empty($_POST["rest-town"])) {
            $restTownErr = true;
            $isErrorRest = true;
        } else {
            $restTown = APIUtil::prepareValueForApi($_POST["rest-street"]);
        }

        if (!empty($_POST["rest-county"])) {
            $restCounty = APIUtil::prepareValueForApi($_POST["rest-county"]);
        }

        if (empty($_POST["rest-postCode"])) {
            $restPostCodeErr = true;
            $isErrorRest = true;
        } else {
            $restTown = APIUtil::prepareValueForApi($_POST["rest-postCode"]);
        }

        $restaurantFormData = [
            "restaurant" => [
                "user_id" => SiteUtil::getUserInfoFromSession("id"),
                "name" => $restName,
                "email" => $restEmail,
                "phone" => $restPhone,
                "open" => false,
                "description" => $restDesc,
                "dine_in" => $restEatIn,
                "delivery" => $restDeliv
            ],
            "address" => [
                "entity_id" => null, //!!!!! THIS NEEDS TO BE SET AFTER CREATING THE RESTAURANT RECORD
                "for_restaurant" => true,
                "street" => $restStreet,
                "town" => $restTown,
                "county" => $restCounty,
                "post_code" => $restPostCode
            ]
        ];

//        var_dump($restaurantFormData);
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
                <input type="password" class="form-control" name="password" id="password" placeholder="New Password" required>
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
        <?php var_dump($pageData); ?>

    <div class="fd-form-container">
        <form action="userPageRestaurant.php" method="post">
            <div class="form-group">
                <label for="rest-name">Name</label>
                <input type="text" class="form-control" name="rest-name" id="rest-name" placeholder="Restaurant Name" required>
            </div>

            <div class="form-group">
                <label for="rest-email">Contact Email</label>
                <input type="text" class="form-control" name="rest-email" id="rest-email" placeholder="Contact email address" required>
<!--                <small class="form-text text-muted">This email address is used by the client to contact the restaurant.</small>-->
                <small class="form-text text-muted">This email address is used by the client to contact the restaurant.</small>
            </div>

            <div class="form-group">
                <label for="rest-phone">Phone</label>
                <input type="text" class="form-control" name="rest-phone" id="rest-phone" placeholder="Contact phone number" required>
            </div>

            <div class="form-group">
                <label for="rest-description">Description</label>
                <textarea class="form-control" name="rest-description" id="rest-description" rows="5" placeholder="Restaurant details"></textarea>
            </div>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="rest-eat-in" name="rest-dine-in" value="<?php echo Restaurant::DINE_IN ?>">
                <label class="form-check-label" for="rest-eat-in">Eat In</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="rest-delivery" name="rest-delivery" value="<?php echo Restaurant::DELIVERY ?>">
                <label class="form-check-label" for="rest-delivery">Delivery</label>
            </div>
            <br>

            <div class="fd-section-delim"></div>

            <h3>Address</h3>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="rest-street" class="form-control mb-2 mr-sm-2 <?php //echo $streetErr ? 'fd-form-input-error' : ''; ?>" value="" placeholder="Street & Number" required>
                </div>

                <div class="col-md-6">
                    <input type="text" name="rest-town" class="form-control mb-2 mr-sm-2 <?php //echo $townErr ? 'fd-form-input-error' : ''; ?>" value="" placeholder="Town" required>
                </div>

                <div class="col-md-6">
                    <input type="text" name="rest-county" class="form-control mb-2 mr-sm-2" value="<?php //echo $clientAddress !== null ? $clientAddress["records"][0]["county"] : '' ?>" placeholder="County">
                </div>

                <div class="col-md-6">
                    <input type="text" name="rest-postCode" class="form-control mb-2 mr-sm-2 <?php //echo $postCodeErr ? 'fd-form-input-error' : ''; ?>" value="" placeholder="Postcode" required>
                </div>
            </div>

            <input type="hidden" name="userPageFormType" value="<?php echo SiteUtil::USER_PAGE_RESTAURANT_FORM ?>">

            <button type="submit" class="btn fd-button">Save</button>
        </form>
    </div>
</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->

</body>
</html>
