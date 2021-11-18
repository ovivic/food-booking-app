<?php

session_start();

require 'config/main.php';

$errorType = 0;
if (isset($_GET["errorType"])) {
    $errorType = $_GET["errorType"];
}

?>


<!doctype html>
<html lang="en">

<?php include "fragments/siteHeader.php"; ?>

<body>

<?php include "fragments/navbar.php" ?>

<div class="container">

    <h1 class="fd-form-page-heading">There has been an error!</h1>
    <div class="fd-form-container" style="height: 400px">
        <?php if ($errorType == SiteUtil::ERROR_CANNOT_ACCESS) { ?>
            <h1 class="text-center">You cannot access this page!</h1>
            <h3 class="text-center">Press <a class="fd-link" href="index.php">here</a> to go back to the main page.</h3>
        <?php } elseif ($errorType == SiteUtil::ERROR_NO_RESTAURANT) { ?>
            <h1 class="text-center">You need to create a restaurant record before adding a menu.</h1>
            <h3 class="text-center">Press <a class="fd-link" href="userPageRestaurant.php">here</a> to go back to the user page.</h3>
        <?php } else { ?>
            <h1 class="text-center">There has been an error!</h1>
            <h3 class="text-center">Press <a class="fd-link" href="index.php.php">here</a> to go back to the main page.</h3>
        <?php } ?>
    </div>


</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->
<script src="app/user-page-restaurant.js"></script>

</body>
</html>

