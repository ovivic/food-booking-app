<?php

require 'config/main.php';

session_start();

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
    header("Location: login.php?showNotLoggedInMessage=1");
}

$restaurantFormStatus = false;
if (isset($_GET["formUpdated"]))
{
    $restaurantFormStatus = $_GET["formUpdated"];
}

// get user's restaurant and address records
$restaurantData = json_decode(APIUtil::getApiRequest(RestaurantController::API_READ_ONE . "?userId=" . SiteUtil::getUserInfoFromSession("id")), true);

$restaurantAddress = null;
$pageData = null;

if (isset($restaurantData["records"])) {
    $pageData["restaurant"] = $restaurantData["records"][0];

    $restaurantID = $restaurantData["records"][0]["id"];
    $restaurantAddress = APIUtil::getApiRequest(AddressController::API_READ_ONE . "?entityId=" . $restaurantID . "&forRestaurant=1");

    if ($restaurantAddress !== null) {
        $pageData["restAddress"] = $restaurantAddress["records"][0];
    }
}

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
            $restPhoneErr = "The phone number cannot be empty";
            $isErrorRest = true;
        } else {
            $restPhone = APIUtil::prepareValueForApi($_POST["rest-phone"]);
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
            $restTown = APIUtil::prepareValueForApi($_POST["rest-town"]);
        }

        if (!empty($_POST["rest-county"])) {
            $restCounty = APIUtil::prepareValueForApi($_POST["rest-county"]);
        }

        if (empty($_POST["rest-postCode"])) {
            $restPostCodeErr = true;
            $isErrorRest = true;
        } else {
            $restPostCode = APIUtil::prepareValueForApi($_POST["rest-postCode"]);
        }


        if (!$isErrorRest) {
            $isRestFormValid = true;

            $restaurantFormData = [
                "restaurant" => [
                    "user_id" => SiteUtil::getUserInfoFromSession("id"),
                    "name" => $restName,
                    "email" => $restEmail,
                    "phone" => $restPhone,
                    "open" => false, // this is false when initially creating the restaurant record
                    "description" => $restDesc,
                    "dine_in" => $restEatIn,
                    "delivery" => $restDeliv
                ],
                "address" => [
                    "entity_id" => $pageData !== null ? $pageData["restAddress"]["entityId"] : null, //!!!!! THIS NEEDS TO BE SET AFTER CREATING THE RESTAURANT RECORD
                    "for_restaurant" => true,
                    "street" => $restStreet,
                    "town" => $restTown,
                    "county" => $restCounty,
                    "post_code" => $restPostCode
                ]
            ];

            if ($pageData !== null)
            {
                $restaurantFormData["restaurant"]["id"] = $pageData["restaurant"]["id"];

                $restaurantRequestResponse = json_decode(APIUtil::putApiRequest(RestaurantController::API_UPDATE, json_encode($restaurantFormData["restaurant"])), true);

                if ($restaurantRequestResponse["status"] == APIUtil::UPDATE_SUCCESSFUL) {
                    $restUpdateStatus = true;
                } elseif ($restaurantRequestResponse["status"] == APIUtil::UPDATE_FAIL) {
                    $restUpdateStatus = false;
                }

                $restaurantFormData["address"]["id"] = $pageData["restAddress"]["id"];

                var_dump($pageData["restAddress"]);
                var_dump($restaurantFormData["address"]);

                $addressRequestResponse = json_decode(APIUtil::putApiRequest(AddressController::API_UPDATE, json_encode($restaurantFormData["address"])), true);

                if ($addressRequestResponse["status"] == APIUtil::UPDATE_SUCCESSFUL) {
                    $restUpdateStatus = true;
                } elseif ($addressRequestResponse["status"] == APIUtil::UPDATE_FAIL) {
                    $restUpdateStatus = false;
                }
            }
            else
            {
                // create restaurant record
                $restaurantRequestResponse = json_decode(APIUtil::postApiRequest(RestaurantController::API_CREATE, json_encode($restaurantFormData["restaurant"])), true);

                $newRestaurantId = null;

                if ($restaurantRequestResponse["status"] == APIUtil::CREATE_SUCCESSFUL) {
                    $restUpdateStatus = true;
                    $newRestaurantId = $restaurantRequestResponse["id"];
                } elseif ($restaurantRequestResponse["status"] == APIUtil::CREATE_FAIL) {
                    $restUpdateStatus = false;
                }

                // create associated address record only if the restaurant record had been created successfully
                if ($newRestaurantId !== null) {
                    $restaurantFormData["address"]["entity_id"] = $newRestaurantId;

                    // create associated address record
                    $addressRequestResponse = json_decode(APIUtil::postApiRequest(AddressController::API_CREATE, json_encode($restaurantFormData["address"])), true);

                    if ($addressRequestResponse["status"] == APIUtil::CREATE_SUCCESSFUL) {
                        $restUpdateStatus = true;
                    } elseif ($addressRequestResponse["status"] == APIUtil::CREATE_FAIL) {
                        $restUpdateStatus = false;
                    }
                }
            }
        }
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

    <h1 class="fd-form-page-heading">Restaurant Details</h1>
    <div class="fd-form-container">
        <?php if ($pageData == null) { ?>
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-shield-exclamation"></i> You have not added a restaurant to your account.
            </div>
        <?php } ?>

        <?php if ($isRestFormValid && $restUpdateStatus == true) { ?>
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle"></i> Your restaurant has been saved successfully.
            </div>
        <?php } elseif ($isRestFormValid && $restUpdateStatus == false) { ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-x-circle"></i> There has been an issue with saving the Restaurant. Please make sure to fill all of the fields.
            </div>
        <?php } ?>

        <p>Use this form to add or edit the restaurant record associated with your account. Press the "Enable Form" button to enable the form for editing.</p>
        <p>After submitting the form for the first time, you will be able to mark it as open for business at which point it will be available in searches.</p>
        <p>If the data you entered in the form does not appear after submitting, try reloading the page.</p>

        <div class="d-flex">
            <button type="button" id="restaurant-form-enable" class="btn fd-button">Enable Form</button>
        </div>

        <form action="userPageRestaurant.php" method="post">
            <div class="form-group">
                <label for="rest-name">Name</label>
                <input type="text" class="form-control <?php echo !empty($restNameErr) ? 'fd-form-input-error' : '' ?>" name="rest-name" id="rest-name" placeholder="Restaurant Name" value="<?php echo $pageData != null ? $pageData["restaurant"]["name"] : '' ?>" required>
                <?php
                    if (!empty($restNameErr)) {
                        echo '<small class="form-text text-muted fd-form-text-error">' . $restNameErr . '</small>';
                    }
                ?>
            </div>

            <div class="form-group">
                <label for="rest-email">Contact Email</label>
                <input type="text" class="form-control <?php echo !empty($restEmailErr) ? 'fd-form-input-error' : '' ?>" name="rest-email" id="rest-email" value="<?php echo $pageData != null ? $pageData["restaurant"]["email"] : '' ?>" placeholder="Contact email address" required>
                <?php
                    if (!empty($restEmailErr)) {
                        echo '<small class="form-text text-muted fd-form-text-error">' . $restEmailErr . '</small>';
                    }
                ?>
                <small class="form-text text-muted">This email address is used by the client to contact the restaurant.</small>
            </div>

            <div class="form-group">
                <label for="rest-phone">Phone</label>
                <input type="text" class="form-control" name="rest-phone" id="rest-phone" value="<?php echo $pageData != null ? $pageData["restaurant"]["phone"] : '' ?>" placeholder="Contact phone number" required>
                <?php
                    if (!empty($restPhoneErr)) {
                        echo '<small class="form-text text-muted fd-form-text-error">' . $restPhoneErr . '</small>';
                    }
                ?>
            </div>

            <div class="form-group">
                <label for="rest-description">Description</label>
                <textarea class="form-control" name="rest-description" id="rest-description" rows="5" placeholder="Restaurant details"><?php echo $pageData != null ? $pageData["restaurant"]["description"] : '' ?></textarea>
            </div>

            <p>What eating options does your restaurant have? (tick applicable)</p>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="rest-eat-in" name="rest-dine-in" value="<?php echo Restaurant::DINE_IN ?>" <?php echo ($pageData != null && $pageData["restaurant"]["dine_in"]) ? 'checked' : '' ?>>
                <label class="form-check-label" for="rest-eat-in">Eat In</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="rest-delivery" name="rest-delivery" value="<?php echo Restaurant::DELIVERY ?>" <?php echo ($pageData != null && $pageData["restaurant"]["delivery"]) ? 'checked' : '' ?>>
                <label class="form-check-label" for="rest-delivery">Delivery</label>
            </div>

            <br>

            <div class="fd-section-delim"></div>

            <h3>Address</h3>
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="rest-street" id="rest-street" class="form-control mb-2 mr-sm-2 <?php echo $restStreetErr ? 'fd-form-input-error' : ''; ?>" value="<?php echo $pageData != null ? $pageData["restAddress"]["street"] : '' ?>" placeholder="Street & Number" required>
                </div>

                <div class="col-md-6">
                    <input type="text" name="rest-town" id="rest-town" class="form-control mb-2 mr-sm-2 <?php echo $restTownErr ? 'fd-form-input-error' : ''; ?>" value="<?php echo $pageData != null ? $pageData["restAddress"]["town"] : '' ?>" placeholder="Town" required>
                </div>

                <div class="col-md-6">
                    <input type="text" name="rest-county" id="rest-county" class="form-control mb-2 mr-sm-2" value="<?php echo $pageData !== null ? $pageData["restAddress"]["county"] : '' ?>" placeholder="County">
                </div>

                <div class="col-md-6">
                    <input type="text" name="rest-postCode" id="rest-postCode" class="form-control mb-2 mr-sm-2 <?php echo $restPostCodeErr ? 'fd-form-input-error' : ''; ?>" value="<?php echo $pageData != null ? $pageData["restAddress"]["postCode"] : '' ?>" placeholder="Postcode" required>
                </div>
            </div>

            <input type="hidden" name="userPageFormType" value="<?php echo SiteUtil::USER_PAGE_RESTAURANT_FORM ?>">

            <button type="submit" id="restaurant-form-submit" class="btn fd-button" disabled>Save</button>
        </form>
    </div>
</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->
<script src="app/user-page-restaurant.js"></script>

</body>
</html>
