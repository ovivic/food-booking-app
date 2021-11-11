<?php
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
        
        <div class="fd-form-button-container">
            <p class="text-center" style="font-size: 25px; margin: 30px 0;">What sort of account would you like to register?</p>

            <div class="row d-flex justify-content-center">
                <button class="btn fd-usertype-selection-button" style="margin-right: 10px">Client</button>
                <button class="btn fd-usertype-selection-button" style="margin-left: 10px">Restaurant</button>
            </div>
        </div>
        
        <form id="user-registration-form">
            <div class="form-group">
                <label for="full-name">Name</label>
                <input type="text" class="form-control" id="full-name" placeholder="Enter your name">
            </div>
            <div class="form-group">
                <label for="email-address">Email address</label>
                <input type="email" class="form-control" id="email-address" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="confirm-password">Confirm password</label>
                <input type="password" class="form-control" id="confirm-password" placeholder="Confirm Password">
            </div>

            <!-- Hidden input to save the value of the client/restaurant account selection -->
            <input type="hidden" name="account-type" id="account-type" value="0">


            <button type="button" class="btn fd-button" id="register-user-button">Submit</button>
        </form>

        <div class="fd-form-footer">
            <p class="text-center">Already registered? Press <a class="fd-link" href="login.php">here</a> to log in</p>
        </div>
    </div>

</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->

</body>
</html>
