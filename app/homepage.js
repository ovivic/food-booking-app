

$(document).ready(function () {
    $.ajax({
        url: "http://localhost/food-booking-app/api/restaurant/read.php",
        type : "GET",
        contentType : 'application/json',
        success : function(result) {
            setHomepageContent(result);
        },
        error: function(xhr, resp, text) {
            // show error to console
            console.log(xhr, resp, text);
        }
    });
});

function setHomepageContent(ajaxResult) {
    $('#app-page-content').html(getPageContent(ajaxResult));
}

function getPageContent(ajaxResult) {
    let pageContent = getJumbotron();

    pageContent += buildPageHtml(ajaxResult);

    return pageContent;
}


function buildPageHtml(ajaxResult) {
    let pageContainer = `<div class="container fd-container">`;

    pageContainer += getFoodRecommendations();

    pageContainer += getFavouriteRestaurants(ajaxResult.records);

    pageContainer += `</div>`;

    return pageContainer;
}

function getFoodRecommendations() {
    let foodRecommendations = `
        <h1 class="text-center">Choose a dish</h1>
        <div class="row fd-restaurant-card-container">`;

    for(let i = 0; i < 3; i++) {
        foodRecommendations += getDishCard();
    }

    foodRecommendations += `
        </div>
    `;

    return foodRecommendations;
}

function getFavouriteRestaurants(restaurants) {
    let favouriteRestaurants  = `
        <h1 class="text-center">Your favourites</h1>
        <div class="row fd-restaurant-card-container">
    `;

    console.log(restaurants[0]);

    for(let i = 0; i < 3; i++) {
        favouriteRestaurants += getRestaurantCard(restaurants[i]);
    }

    favouriteRestaurants += `
        </div>
    `;

    return favouriteRestaurants;
}

function getDishCard() {
    return `
        <div class="col-lg-4">
            <div class="card fd-restaurant-card">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>
        </div>
    `;
}

function getRestaurantCard(restaurantObject) {
    return `
        <div class="col-lg-4">
            <div class="card fd-restaurant-card">
                <img class="card-img-top" src="https://dummyimage.com/600x200/000/fff.jpg" alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">` + restaurantObject.name + `</h5>
                    <p class="card-text">` + restaurantObject.email + `</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    `;
}

function getJumbotron() {
    return `
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
                </div>
            </div>
        </div>

        <!--  UPDATE THE FORM HERE  -->
        <div class="d-md-none fd-sm-homepage-form">
            <h1>Eat in or takeaway?</h1>
        </div>
    `;
}