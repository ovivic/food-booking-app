<?php

require 'config/main.php';

session_start();

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
    header("Location: login.php?showNotLoggedInMessage=1");
}

function getUserInfoFromSession(string $field) {
    if (isset($_SESSION["userData"][$field]) && !empty($_SESSION["userData"][$field])) {
        return $_SESSION["userData"][$field];
    }

    return null;
}

$password = '';
$isError = false;
$isFormValid = false;
$updatedStatus = false;

// password reset form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["password"])) {
        $passwordErr = "Password cannot be empty";
        $isError = true;
    } else {
        $password = APIUtil::prepareValueForApi($_POST["password"]);

        if (strlen($password) < 8 || strlen($password) > 16) {
            $passwordErr = "Must be between 8 and 16 characters";
            $isError = true;
        }
    }

    if (empty($_POST["confirm-password"])) {
        $confirmPasswordError = "The password confirmation cannot be empty";
        $isError = true;
    } else {
        $confirmPassword = APIUtil::prepareValueForApi($_POST["confirm-password"]);

        if ($confirmPassword != $password) {
            $confirmPasswordError = "The passwords do not match";
            $isError = true;
        }
    }

    if (!$isError) {
        $isFormValid = true;

        $formData = [
            "id" => getUserInfoFromSession("id"),
            "password" => $password
        ];

        $formStatus = json_decode(APIUtil::putApiRequest(UserController::API_UPDATE, json_encode($formData)), true);

        if ($formStatus["status"] == APIUtil::UPDATE_SUCCESSFUL) {
            $updatedStatus = true;
        } elseif ($formStatus["status"] == APIUtil::UPDATE_FAIL) {
            $updatedStatus = false;
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
            <p><span>Name: </span><?php echo getUserInfoFromSession("name"); ?></p>
        </div>
        <div class="fd-user-detail-container">
            <p><span>Email: </span><?php echo getUserInfoFromSession("email"); ?></p>
        </div>
        <p>ADD ADDRESS HERE</p>

        <h3>Account Details</h3>
        <div class="fd-user-detail-container">
            <p><span>Username: </span><?php echo getUserInfoFromSession("username"); ?></p>
        </div>

        <?php if ($isFormValid && $updatedStatus == true) { ?>
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle"></i> Your password has been updated successfully.
            </div>
        <?php } elseif ($isFormValid && $updatedStatus == false) { ?>
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
                    echo '<small id="passwordError" class="form-text text-muted">' . $passwordErr . '</small>';
                }
                ?>
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm password</label>
                <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Confirm Password" required>
                <?php
                if (!empty($confirmPasswordError)) {
                    echo '<small id="confirmPasswordError" class="form-text text-muted">' . $confirmPasswordError . '</small>';
                }
                ?>
            </div>

            <button type="submit" class="btn fd-button">Reset Password</button>
        </form>

    </div>

    <h1 class="fd-form-page-heading">Past Orders</h1>
    <div class="fd-form-container">

    </div>

</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->

</body>
</html>