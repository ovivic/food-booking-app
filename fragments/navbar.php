<?php

function getUserPageLink(string $destination)
{
    $userFullName = isset($_SESSION["userData"]) ? $_SESSION["userData"]["name"] : "User";

    return '<a class="nav-link fd-navbar-user-page-link" href="' . $destination . '">
                <i class="bi bi-person-circle"></i> ' . $userFullName . '
            </a>';
}

?>

<nav class="navbar navbar-expand-lg navbar-light fd-navbar">
    <div class="container">
        <a class="navbar-brand fd-navbar-brand" href="index.php">FINE DINING</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) { ?>
                    <li class="nav-item ">
                        <?php
                            $accountType = 0;

                            if (isset($_SESSION["userData"]) && $_SESSION["userData"]["type"]) {
                                $accountType = $_SESSION["userData"]["type"];

                                if ($accountType == 1) {
                                    echo getUserPageLink("userPageClient.php");
                                } elseif ($accountType == 2) {
                                    echo getUserPageLink("userPageRestaurant.php");
                                }
                            }

                        ?>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link fd-nav-link" href="logout.php">Log Out</a>
                    </li>
                <?php } else { ?>
                    <li class="nav-item ">
                        <a class="nav-link fd-nav-link" href="registration.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fd-nav-link" href="login.php">Log In</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fd-nav-link" href="#">Help</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>