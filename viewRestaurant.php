<?php

require 'config/main.php';

session_start();

function getMenuItemDiv($menuItem)
{
    return '
        <div class="d-flex justify-content-between fd-rest-page-menu-item">
            <p style="font-weight: bold">' . $menuItem["name"] . '</p>
            <p> ' . SiteUtil::formatCurrency($menuItem["price"]) . ' </p>
        </div>
    ';
}

function getRestaurantTableDiv($table, $restaurantId)
{
    $wrapperDivStart = '<div class="col-auto mb-1">';
    $wrapperDivEnd = '</div>';

    $formSelect = '<select class="form-control" name="tableSelectedSeats" required>';

    $formSelect .= '<option value="0">Choose Seats...</option>';

    for ($i = 1; $i <= $table["max_seats"]; $i += 1 )
    {
        if ($i == 1)
        {
            $formSelect .= '<option value="' . $i . '">' . $i . ' Seat</option>';
        }
        else
        {
            $formSelect .= '<option value="' . $i . '">' . $i . ' Seats</option>';
        }

    }

    $formSelect .= '</select>';

    $formDate = '<input class="form-control" type="date" name="tableSelectedDate" required>';

    $formSubmit = '<button type="submit" class="btn fd-button">Add</button>';

    $formHiddenType = '<input type="hidden" name="restViewFormType" value="' . SiteUtil::RESTAURANT_VIEW_PAGE_ADD_BOOKING . '">';
    $formHiddenTableId = '<input type="hidden" name="tabletableId" value="' . $table["id"] . '">';

    $form = '<form class="form-inline" action="viewRestaurant.php?restaurantId=' . $restaurantId . '" method="post">';

    $form .= $formHiddenType;
    $form .= $formHiddenTableId;

    $form .= $wrapperDivStart . $formSelect . $wrapperDivEnd;
    $form .= $wrapperDivStart . $formDate . $wrapperDivEnd;
    $form .= $wrapperDivStart . $formSubmit . $wrapperDivEnd;

    $form .= '</form>';

    return '
        <div class="fd-rest-page-table">
            <div class="row">
                <div class="col d-flex justify-content-between">
                    <p style="font-weight: bold">' . $table["name"] . '</p>
                    <p><span style="font-weight: bold">Max: </span>' . $table["max_seats"] . ' </p>        
                </div>
                <div class="col"><div class="form-row">' . $form . '</div></div>
            </div>
        </div>
    ';
}

$restaurantId = null;

if (isset($_GET["restaurantId"]) && $_GET["restaurantId"])
{
    $restaurantId = $_GET["restaurantId"];
}

// redirect ot error
if ($restaurantId == 0 || $restaurantId == null)
{
    header(SiteUtil::ERROR_PAGE . SiteUtil::ERROR_NO_RESTAURANT);
}

$pageData = [];

// get restaurantData
$restaurantResponse = json_decode(APIUtil::getApiRequest(RestaurantController::API_READ_ONE . "?restaurantId=" . $restaurantId), true);

if (isset($restaurantResponse["records"]))
{
    $pageData["restaurant"] = $restaurantResponse["records"][0];
}

// get restaurant Address data
$restAddressResponse = APIUtil::getApiRequest(AddressController::API_READ_ONE . "?entityId=" . $restaurantId . "&forRestaurant=true");

if (isset($restAddressResponse["records"]))
{
    $pageData["restAddress"] = $restAddressResponse["records"][0];
}

// get restaurant menu
$menuResponse = APIUtil::getApiRequest(MenuItemController::API_READ_ALL . "?restaurantId=" . $pageData["restaurant"]["id"]);

if (isset($menuResponse["records"])) {
    $pageData["menu"] = $menuResponse["records"];
}

// get restaurant Tables
if ($pageData["restaurant"]["dine_in"])
{
    $restTableData = APIUtil::getApiRequest(RestaurantTableController::API_READ_ALL . "?restaurantId=" . $pageData["restaurant"]["id"]);

    if (isset($restTableData["records"])) {
        $pageData["restaurantTables"] = $restTableData["records"];
    }

    $tableBookingData = APIUtil::getApiRequest(TableBookingController::API_READ_ALL . "?restaurantId=" . $pageData["restaurant"]["id"]);

    if (isset($tableBookingData["records"]))
    {
        $bookings = [];

        foreach ($tableBookingData["records"] as $booking)
        {
            $bookings[$booking["id"]] = $booking;
        }

        $pageData["tableBookings"] = $bookings;
    }
}

//var_dump($pageData["tableBookings"]);

$tableId = $selectedSeats = $selectedDate = $formattedDate = '';
$selectedSeatsErr = $selectedDateErr = '';
$tableBookingFormError = false;
$bookingAdded = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["restViewFormType"])) {
    if ($_POST["restViewFormType"] == SiteUtil::RESTAURANT_VIEW_PAGE_ADD_BOOKING) // the password reset form was submitted
    {
        if(!empty($_POST["tabletableId"])) {
            $tableId = $_POST["tabletableId"];
        }

        if (isset($_POST["tableSelectedSeats"]) && $_POST["tableSelectedSeats"] == 0)
        {
            $selectedSeatsErr = "Please select the number of seats you would like to book.";
            $tableBookingFormError = true;
        }
        else
        {
            $selectedSeats = $_POST["tableSelectedSeats"];
        }

        if (empty($_POST["tableSelectedDate"]))
        {
            $selectedDateErr = "Please choose the date of the booking.";
            $tableBookingFormError = true;
        }
        else
        {
            $selectedDate = $_POST["tableSelectedDate"];
        }

        if (!$tableBookingFormError)
        {
            $bookingAddFormData = [
                "restaurant_id" => $restaurantId,
                "table_id" => $tableId,
                "user_id" => SiteUtil::getUserInfoFromSession("id"),
                "date" => $selectedDate,
                "seats" => $selectedSeats
            ];

            $bookingAddResponse = json_decode(APIUtil::postApiRequest(TableBookingController::API_CREATE, json_encode($bookingAddFormData)) , true);

            if ($bookingAddResponse["status"] == APIUtil::CREATE_SUCCESSFUL)
            {
                $bookingAdded = true;
            }
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

    <div class="container">

        <h1 class="fd-rest-page-heading"><?php echo $pageData["restaurant"]["name"]; ?></h1>
        <p class="fd-rest-page-subheading"><?php echo isset($pageData["restAddress"]) ? $pageData["restAddress"]["addressString"] : '' ?></p>
        <div class="fd-form-container">
            <div class="row">
                <div class="col">
                    <h3>Contact</h3>
                    <div class="fd-user-detail-container">
                        <p><span>Email: </span><?php echo $pageData["restaurant"]["email"]; ?></p>
                    </div>
                    <div class="fd-user-detail-container">
                        <p><span>Phone: </span><?php echo $pageData["restaurant"]["phone"]; ?></p>
                    </div>
                    <div class="fd-user-detail-container">
                        <p><span>Address: </span><?php echo $pageData["restAddress"]["addressString"]; ?></p>
                    </div>
                </div>

                <div class="col">
                    <h3>Description</h3>
                    <p><?php echo $pageData["restaurant"]["description"]; ?></p>
                </div>
            </div>

            <div class="fd-section-delim"></div>

            <h3>Menu</h3>
            <p>Please find bellow the menu. Click on an item to add it to the cart for delivery.</p>

            <?php
                // create menu items
                foreach ($pageData["menu"] as $menuItem)
                {
                    echo getMenuItemDiv($menuItem);
                }

            ?>

            <?php if ($pageData["restaurant"]["dine_in"]) { ?>
                <div class="fd-section-delim"></div>

                <h3>Tables</h3>
                <p>Find below a list of tables that the restaurant has available for a booking.</p>

                <?php if ($tableBookingFormError) { ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-x-circle"></i> There are errors in the form. Please make sure you select both the number of people attending and the date of the booking.
                    </div>
                <?php } ?>

                <?php if (!$tableBookingFormError && $bookingAdded == true) { ?>
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle"></i> Your booking for the date of <?php echo $selectedDate ?> has been added successfully.
                    </div>
                <?php } elseif (!$tableBookingFormError && $bookingAdded == true) { ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="bi bi-x-circle"></i> There is an issue with the creation of the booking. Please refresh the page and try again.
                    </div>
                <?php } ?>

                <?php
                    // create menu items
                    foreach ($pageData["restaurantTables"] as $table)
                    {
                        echo getRestaurantTableDiv($table, $pageData["restaurant"]["id"]);
                    }

                ?>
            <?php } ?>

        </div>
    </div>

</div>


<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->

</body>
</html>

