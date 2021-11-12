<?php

require 'config/main.php';

$successfullyRegistered = '';

if (isset($_GET["fromSuccessfulRegistration"]) && !empty($_GET["fromSuccessfulRegistration"])) {
    $successfullyRegistered = $_GET["fromSuccessfulRegistration"];
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
                <i class="bi bi-x-circle"></i> There is an error in the login form.
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
            <p class="text-center">Don't have an account? Press <a class="fd-link" href="registration.php">here</a> to register</p>
        </div>
    </div>
</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->

</body>
</html>

