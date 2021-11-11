<?php

    require 'config/main.php';

    $homePageData = APIUtil::getApiResult(RestaurantController::API_READ_ALL);

    var_dump($homePageData["records"]);

    function getFoodCategoryCard() {
        return '
            <div class="col-lg-4">
                <div class="card fd-restaurant-card">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card\'s content.</p>
                    </div>
                </div>
            </div>
        ';
    }

    function getRestaurantCard($restaurantObject) {
        return '
            <div class="col-lg-4">
                <div class="card fd-restaurant-card">
                    <img class="card-img-top" src="https://dummyimage.com/600x200/000/fff.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">' . $restaurantObject["name"] . '</h5>
                        <p class="card-text">' . $restaurantObject["email"] . '</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        ';
    }

?>


<!doctype html>
<html lang="en">

<?php include "fragments/siteHeader.php"; ?>

<body>

    <?php include "fragments/navbar.php" ?>

    <div class="jumbotron jumbotron-fluid d-none d-md-block fd-jumbotron d-md-none">
        <div class="fd-homepage-form text-center">
            <h1>Eat in or takeaway?</h1>
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <a class="btn btn-primary fd-homepage-form-button" href="#">BOOK TABLE</a>
                </div>
                <div class="col-md-4">
                    <a class="btn btn-primary fd-homepage-form-button" href="#">FIND DELIVERY</a>
                </div>
                <div class="col-md-2"></div>

<!--            add form here    -->

            </div>
        </div>
    </div>

    <!--  UPDATE THE FORM HERE  -->
    <div class="d-md-none fd-sm-homepage-form">
        <h1>Eat in or takeaway?</h1>

<!--    add form here    -->
    </div>

    <div class="container fd-container">
        <!-- FOOD CATEGORY SELECTION HERE -->
        <h1 class="text-center">Choose a dish</h1>
        <div class="row fd-restaurant-card-container">
        <?php

            for ($i = 0; $i < 3; $i++) {
                echo getFoodCategoryCard();
            }

        ?>
        </div>


        <!-- FAVOURITE RESTAURANTS SELECTION HERE -->
        <h1 class="text-center">Your favourites</h1>
        <div class="row fd-restaurant-card-container">
        <?php

        foreach ($homePageData["records"] as $record) {
            echo getRestaurantCard($record);
        }

        ?>
        </div>


        <!-- FEATURED RESTAURANTS SELECTION HERE -->
        <h1 class="text-center">Featured</h1>
        <div class="row fd-restaurant-card-container">
        <?php

        foreach ($homePageData["records"] as $record) {
            echo getRestaurantCard($record);
        }

        ?>
        </div>


        <!-- HIGHEST RATED RESTAURANTS SELECTION HERE -->
        <h1 class="text-center">HighestRated</h1>
        <div class="row fd-restaurant-card-container">
        <?php

        foreach ($homePageData["records"] as $record) {
            echo getRestaurantCard($record);
        }

        ?>
        </div>
    </div>

    <?php include "fragments/footer.php"; ?>

    <?php include "fragments/siteScripts.php"; ?>

    <!--  add any custom scripts for this page here  -->

</body>
</html>
