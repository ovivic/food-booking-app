<?php

require 'config/main.php';

session_start();

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
    header("Location: login.php?showNotLoggedInMessage=1");
}

// API call to load the address for the user

$clientAddress = APIUtil::getApiRequest(AddressController::API_READ_ONE . "?entityId=" . SiteUtil::getUserInfoFromSession("id"));

if ($clientAddress !== null) {
    $_SESSION["userData"]["address"] = $clientAddress["records"][0]["addressString"];
}

$pageData = [];

$tableBookingsData = APIUtil::getApiRequest(TableBookingController::API_READ_ALL . '?userId=' . SiteUtil::getUserInfoFromSession("id"));

if (isset($tableBookingsData["records"]))
{
    $pageData["bookings"] = $tableBookingsData["records"];
}

$password = '';
$isErrorPassChange = false;
$isPasswordFormValid = false;
$passwordUpdatedStatus = false;


$streetErr = $townErr = $postCodeErr = false;
$street = $town = $county = $postCode = '';
$isErrorAddress = false;
$isAddressFormValid = false;
$addressUpdatedStatus = false;

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

    if ($_POST["userPageFormType"] == SiteUtil::USER_PAGE_ADDRESS_FORM) // address create/edit form has been submitted
    {
        if (empty($_POST["user-street"])) {
            $isErrorAddress = true;
            $streetErr = true;
        } else {
            $street = APIUtil::prepareValueForApi($_POST["user-street"]);
        }

        if (empty($_POST["user-town"])) {
            $isErrorAddress = true;
            $townErr = true;
        } else {
            $town = APIUtil::prepareValueForApi($_POST["user-town"]);
        }

        if (!empty($_POST["user-county"])) {
            $county = APIUtil::prepareValueForApi($_POST["user-county"]);
        }

        if (empty($_POST["user-postCode"])) {
            $isErrorAddress = true;
            $postCodeErr = true;
        } else {
            $postCode = APIUtil::prepareValueForApi($_POST["user-postCode"]);
        }

        if (!$isErrorAddress)
        {
            $isAddressFormValid = true;

            $addressFormData = [
                "entity_id" => SiteUtil::getUserInfoFromSession("id"),
                "for_restaurant" => false, // !!!!
                "street" => $street,
                "town" => $town,
                "county" => $county,
                "post_code" => $postCode
            ];

            if ($clientAddress !== null) // PUT request to update the address record
            {
                $addressFormData["id"] = $clientAddress["records"][0]["id"];

                $addressRequestResponse = json_decode(APIUtil::putApiRequest(AddressController::API_UPDATE, json_encode($addressFormData)), true);

                if ($addressRequestResponse["status"] == APIUtil::UPDATE_SUCCESSFUL) {
                    $addressUpdatedStatus = true;
                } elseif ($addressRequestResponse["status"] == APIUtil::UPDATE_FAIL) {
                    $addressUpdatedStatus = false;
                }
            }
            else // POST request to create the address record
            {
                $addressRequestResponse = json_decode(APIUtil::postApiRequest(AddressController::API_CREATE, json_encode($addressFormData)), true);

                if ($addressRequestResponse["status"] == APIUtil::CREATE_SUCCESSFUL) {
                    $addressUpdatedStatus = true;
                } elseif ($addressRequestResponse["status"] == APIUtil::CREATE_FAIL) {
                    $addressUpdatedStatus = false;
                }
            }
        }
    }

    if ($_POST["userPageFormType"] == SiteUtil::USER_PAGE_TABLE_BOOKING_DELETE_FORM)
    {
        $bookingId = $_POST["tableBookingId"];

        $bookingDeleteResponse = json_decode(APIUtil::deleteApiRequest(TableBookingController::API_DELETE . "?tableBookingId=" . $bookingId), true);

        // redirect to this page to reload page data
        if ($bookingDeleteResponse["status"] == APIUtil::DELETE_SUCCESSFUL)
        {
            header("Location: userPageClient.php");
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

        <div class="d-flex justify-content-between">
            <h3>Personal Details</h3>
            <div>
                <a href="#user-delivery-orders" class="btn fd-button">View Deliveries</a>
                <a href="#user-eatin-bookings" class="btn fd-button">View Bookings</a>
            </div>
        </div>

        <div class="fd-user-detail-container">
            <p><span>Name: </span><?php echo SiteUtil::getUserInfoFromSession("name"); ?></p>
        </div>
        <div class="fd-user-detail-container">
            <p><span>Email: </span><?php echo SiteUtil::getUserInfoFromSession("email"); ?></p>
        </div>

        <?php if (isset($_SESSION["userData"]["address"]) && !empty($_SESSION["userData"]["address"])) { ?>
            <div class="fd-user-detail-container">
                <p>
                    <span>Address: </span>
                    <?php echo SiteUtil::getUserInfoFromSession("address"); ?>
                    <button class="btn fd-button fd-btn-userpage-inline" id="show-address-form" type="button">Edit</button>
                </p>
            </div>
        <?php } else { ?>
            <div class="fd-user-detail-container">
                <p>
                    <span>Address: </span>
                    You have not added an address to your account. Press the button to create one.
                    <button class="btn fd-button fd-btn-userpage-inline" id="show-address-form" type="button">Create</button>
                </p>
            </div>
        <?php } ?>

        <!-- add the address edit/create form -->

        <?php if ($isAddressFormValid && $addressUpdatedStatus == true) { ?>
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle"></i> Your address has been saved successfully.
            </div>
        <?php } elseif ($isAddressFormValid && $addressUpdatedStatus == false) { ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-x-circle"></i> There has been an issue with saving the address. Please make sure to fill all of the fields. The "County" is not required.
            </div>
        <?php } ?>

        <form class="form-inline" id="userpage-address-form" method="post" action="userPageClient.php">
            <input type="text" name="user-street" class="form-control mb-2 mr-sm-2 <?php echo $streetErr ? 'fd-form-input-error' : ''; ?>" value="<?php echo $clientAddress !== null ? $clientAddress["records"][0]["street"] : '' ?>" placeholder="Street & Number" required>

            <input type="text" name="user-town" class="form-control mb-2 mr-sm-2 <?php echo $townErr ? 'fd-form-input-error' : ''; ?>" value="<?php echo $clientAddress !== null ? $clientAddress["records"][0]["town"] : '' ?>" placeholder="Town" required>

            <input type="text" name="user-county" class="form-control mb-2 mr-sm-2" value="<?php echo $clientAddress !== null ? $clientAddress["records"][0]["county"] : '' ?>" placeholder="County">

            <input type="text" name="user-postCode" class="form-control mb-2 mr-sm-2 <?php echo $postCodeErr ? 'fd-form-input-error' : ''; ?>" value="<?php echo $clientAddress !== null ? $clientAddress["records"][0]["postCode"] : '' ?>" placeholder="Postcode" required>

            <input type="hidden" name="userPageFormType" value="<?php echo SiteUtil::USER_PAGE_ADDRESS_FORM ?>">

            <button type="submit" class="btn btn fd-button mb-2">Submit</button>
        </form>

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

        <form id="password-reset-form" action="userPageClient.php" method="POST">
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

    <h1 class="fd-form-page-heading" id="user-delivery-orders">Delivery Orders</h1>
    <div class="fd-form-container">

    </div>

    <h1 class="fd-form-page-heading" id="user-eatin-bookings">Eat In Bookings</h1>
    <div class="fd-form-container">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Restaurant Name</th>
                <th scope="col">Table</th>
                <th scope="col">Seats</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            <?php
                $counter = 1;
                foreach ($pageData["bookings"] as $booking)
                {
                    $tableRow = "<tr><th scope=\"row\">" . $counter . "</th>";

                    $tableRow .= "<td>" . $booking["restaurant_id"] . "</td>";
                    $tableRow .= "<td>" . $booking["table_id"] . "</td>";
                    $tableRow .= "<td>" . $booking["seats"] . "</td>";
                    $tableRow .= "<td>" . $booking["date"] . "</td>";

                    $deleteForm = "<form class='fd-menu-item-delete-form' method='POST' action='userPageClient.php'>";
                    $deleteForm .= "<input type='hidden' name='userPageFormType' value='" . SiteUtil::USER_PAGE_TABLE_BOOKING_DELETE_FORM . "'>";
                    $deleteForm .= "<input type='hidden' name='tableBookingId' value='" . $booking["id"] . "'>";
                    $deleteForm .= "<button type='submit' id='rest-table-delete" . $counter . "' class='btn fd-button'>Delete</button>";
                    $deleteForm .= "</form>";

                    $tableRow .= "<td>" . $deleteForm . "</td>";

                    $tableRow .= "</tr>";

                    $counter += 1;

                    echo $tableRow;
                }
            ?>
            </tbody>
        </table>
    </div>

</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->
<script src="app/user-page-client.js"></script>

</body>
</html>