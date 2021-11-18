<?php

require 'config/main.php';

session_start();


$userLoggedIn = false;
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]) {
    $userLoggedIn = true;
}


?>

<!doctype html>
<html lang="en">

<?php include "fragments/siteHeader.php"; ?>

<body>

<?php include "fragments/navbar.php" ?>

<div class="container">

    <h1 class="fd-form-page-heading">Delivery Order Placed!</h1>
    <div class="fd-form-container" style="height: 400px">
        <h1 class="text-center">Your delivery order has been placed successfully. It should be with you soon.</h1>
        <h3 class="text-center">Press <a class="fd-link" href="index.php">here</a> to go back to the main page.</h3>
    </div>

</div>


<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->

</body>
</html>
