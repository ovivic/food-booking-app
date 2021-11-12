<?php

require 'config/main.php';

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("Location: index.php");
    exit;
}

$nameErr = $emailErr = $usernameErr = $passwordErr = $confirmPasswordError = $accountTypeErr = '';
$name = $email = $username = $password = $confirmPassword = $accountType = '';

$isError = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userCreated = false;

    if (empty($_POST["full-name"])) {
        $nameErr = "Name is required";
        $isError = true;
    } else {
        $name = APIUtil::prepareValueForApi($_POST["full-name"]);

        if (!preg_match("/^[a-zA-Z-' ]*$/", $name)) {
            $nameErr = "Only letters and white space allowed";
            $isError = true;
        }
    }

    if (empty($nameErr))

    if (empty($_POST["email"])) {
        $emailErr = "Email address is required";
        $isError = true;
    } else {
        $email = APIUtil::prepareValueForApi($_POST["email"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $isError = true;
        }
    }

    // NEED TO MAKE SURE THE USER IS UNIQUE
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
        $isError = true;
    } else {
        $username = APIUtil::prepareValueForApi($_POST["username"]);

        if (strlen($username) < 5 || strlen($username) > 12) {
            $usernameErr = "Must be between 5 and 12 characters";
            $isError = true;
        }

        if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
            $usernameErr = "Only letters and numbers allowed";
            $isError = true;
        }
    }

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

    if ($_POST["account-type"] == 0) {
        $accountTypeErr = "Please select an account type";
        $isError = true;
    } else {
        $accountType = $_POST["account-type"];
    }

    if (!$isError)
    {
        $formArray = [
            "name" => $name,
            "email" => $email,
            "username" => $username,
            "password" => $password,
            "type" => $accountType
        ];

        $formStatus = json_decode(APIUtil::postApiRequest(UserController::API_CREATE, json_encode($formArray)), true);

        // only send the form data if there is no error on the form
        if ($formStatus["status"] == APIUtil::CREATE_SUCCESSFUL)
        {
            $userCreated = true;
            // head to the log in page - with a get arg to display a message that you cam from here to let you login
            header("Location: login.php?fromSuccessfulRegistration=1");
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

    <h1 class="fd-form-page-heading">Registration</h1>

    <div class="fd-form-container">
        <p>Welcome to Fine Dining. You can register as a client if you only want to book try the food, or you can register you own restaurant to start selling your menu. Don't forget to follow us on social media to stay up date to any special offers there might be.</p>

        <?php
        if (defined($userCreated) && !$userCreated) {
            echo '<div class="alert alert-danger"><i class="bi bi-x-circle"></i> There is already a user with that username</div>';
        }
        ?>

        <div class="fd-form-button-container">
            <p class="text-center" style="font-size: 25px; margin: 30px 0;">What sort of account would you like to register?</p>

            <div class="row d-flex justify-content-center" id="fd-registration-buttons" style="margin-bottom: 30px">
                <button class="btn fd-usertype-selection-button" style="margin-right: 10px">Client</button>
                <button class="btn fd-usertype-selection-button" style="margin-left: 10px">Restaurant</button>
            </div>

            <?php
                if (!empty($accountTypeErr)) {
                    echo '<div class="alert alert-danger"><i class="bi bi-x-circle"></i> ' . $accountTypeErr . '</div>';
                }
            ?>

        </div>
        
        <form id="user-registration-form" action="registration.php" method="POST">
            <div class="form-group">
                <label for="full-name">Name</label>
                <input type="text" class="form-control" name="full-name" id="full-name" placeholder="Enter your name" required value="<?php if (!empty($name)) echo $name ?>">
                <?php
                    if (!empty($nameErr)) {
                        echo '<small id="nameError" class="form-text text-muted">' . $nameErr . '</small>';
                    }
                ?>
            </div>
            <div class="form-group">
                <label for="email-address">Email address</label>
                <input type="email" class="form-control" name="email" id="email-address" placeholder="Enter email" required value="<?php if (!empty($email)) echo $email ?>">
                <?php
                    if (!empty($emailErr)) {
                        echo '<small id="emailError" class="form-text text-muted">' . $emailErr . '</small>';
                    }
                ?>
            </div>
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
            <div class="form-group">
                <label for="confirm-password">Confirm password</label>
                <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="Confirm Password" required>
                <?php
                    if (!empty($confirmPasswordError)) {
                        echo '<small id="confirmPasswordError" class="form-text text-muted">' . $confirmPasswordError . '</small>';
                    }
                ?>
            </div>

            <!-- Hidden input to save the value of the client/restaurant account selection -->
            <input type="hidden" name="account-type" id="fd-registration-account-type" value="<?php echo (!empty($accountType) && $accountType != 0) ? $accountType : "0"; ?>">


            <button type="submit" class="btn fd-button" id="register-user-button">Submit</button>
        </form>

        <div class="fd-form-footer">
            <p class="text-center fd-footer-para-border">Already registered? Press <a class="fd-link" href="login.php">here</a> to log in.</p>
            <p class="text-center">Don't want to create an account? Press <a class="fd-link" href="index.php">here</a> to view the menu before you decide to sign in with us.</p>
        </div>
    </div>

</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->
<script src="app/user-registration.js"></script>

</body>
</html>
