<?php

require 'config/main.php';

session_start();

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
    header("Location: login.php?showNotLoggedInMessage=1");
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
