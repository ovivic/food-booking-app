<?php

require 'config/main.php';

$successfullyRegistered = '';

if (isset($_GET["fromSuccessfulRegistration"]) && !empty($_GET["fromSuccessfulRegistration"])) {
    $successfullyRegistered = $_GET["fromSuccessfulRegistration"];
}

$showNotLoggedInMessage = '';

if (isset($_GET["showNotLoggedInMessage"]) && !empty($_GET["showNotLoggedInMessage"])) {
    $showNotLoggedInMessage = $_GET["showNotLoggedInMessage"];
}

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("Location: index.php");
    exit;
}

$username = $password = '';
$isError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
        $isError = true;
    } else {
        $username = APIUtil::prepareValueForApi($_POST["username"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password cannot be empty";
        $isError = true;
    } else {
        $password = APIUtil::prepareValueForApi($_POST["password"]);
    }

    $dataArray = [
        "username" => $username,
        "password" => $password
    ];

    if (!$isError) {
        $requestResponse = json_decode(APIUtil::postApiRequest(UserController::API_LOGIN, json_encode($dataArray)), true);

        if ($requestResponse["status"] == APIUtil::LOGIN_SUCCESSFUL) {
            session_start();

            $_SESSION["loggedin"] = true;
            $_SESSION["userData"] = $requestResponse["user"];

            $userAddressResponse = APIUtil::getApiRequest(AddressController::API_READ_ONE . "?entityId=" . SiteUtil::getUserInfoFromSession("id"));

            if (isset($userAddressResponse["records"]))
            {
                $_SESSION["userData"]["address"] = $userAddressResponse["records"][0]["addressString"];
            }

            header("Location: index.php");
        } else {
            $isError = true;
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

    <h1 class="fd-form-page-heading">Log In</h1>

    <div class="fd-form-container">

        <?php if ($successfullyRegistered) { ?>
            <div class="alert alert-success" role="alert">
                <i class="bi bi-check-circle"></i> Congratulations, you have registered successfully. Now you can login!
            </div>
        <?php } ?>

        <?php if ($isError) { ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-x-circle"></i> The username and password combination you entered is not valid.
            </div>
        <?php } ?>

        <?php if ($showNotLoggedInMessage) { ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-x-circle"></i> This page cannot be accessed if you are not logged in. Please log in below or create an account to continue.
            </div>
        <?php } ?>

        <form id="user-login-form" action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required value="<?php if (!empty($username)) echo $username ?>">
                <?php
                    if (!empty($usernameErr)) {
                        echo '<small id="usernameError" class="form-text text-muted">' . $usernameErr . '</small>';
                    }
                ?>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required value="<?php if (!empty($password)) echo $password; ?>">
                <?php
                    if (!empty($passwordErr)) {
                        echo '<small id="passwordError" class="form-text text-muted">' . $passwordErr . '</small>';
                    }
                ?>
            </div>

            <button type="submit" class="btn fd-button" id="login-user-button">Log In</button>
        </form>

        <div class="fd-form-footer">
            <p class="text-center fd-footer-para-border">Don't have an account? Press <a class="fd-link" href="registration.php">here</a> to register.</p>
            <p class="text-center fd-footer-para-border">Forgot your password? Click <a href="#" class="fd-link">here</a> to reset it.</p>
            <p class="text-center">Don't want to create an account? Press <a class="fd-link" href="index.php">here</a> to view the menu before you decide to sign in with us.</p>
        </div>
    </div>
</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->

</body>
</html>

