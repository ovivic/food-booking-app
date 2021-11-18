<?php
require 'config/main.php';

session_start();

if (!isset($_SESSION["loggedin"]) && !$_SESSION["loggedin"]) {
    header("Location: login.php?showNotLoggedInMessage=1");
}

// if accessed by client user redirect to error page
if (SiteUtil::getUserInfoFromSession("type") === User::CLIENT_TYPE) {
    header(SiteUtil::ERROR_PAGE . SiteUtil::ERROR_CANNOT_ACCESS);
}

// get the restaurant record associated with the account
$restaurantData = json_decode(APIUtil::getApiRequest(RestaurantController::API_READ_ONE . "?userId=" . SiteUtil::getUserInfoFromSession("id")), true);

$pageData = [];

if (isset($restaurantData["records"])) {
    $pageData["restaurant"] = $restaurantData["records"][0];
} else {
    header(SiteUtil::ERROR_PAGE . SiteUtil::ERROR_NO_RESTAURANT);
}

$restTableData = APIUtil::getApiRequest(RestaurantTableController::API_READ_ALL . "?restaurantId=" . $pageData["restaurant"]["id"]);

if (isset($restTableData["records"])) {
    $pageData["restaurantTables"] = $restTableData["records"];
}

//var_dump($pageData);

$tableBookingData = APIUtil::getApiRequest(TableBookingController::API_READ_ALL . "?restaurantId=" . $pageData["restaurant"]["id"]);

//var_dump($tableBookingData["records"]);

$updatedTableRecords = [];
if (isset($pageData["restaurantTables"])) {
    foreach ($pageData["restaurantTables"] as $table) {
        $tableBookings = [];

        foreach ($tableBookingData["records"] as $booking) {
            if ($booking["table_id"] === $table["id"]) {
                array_push($tableBookings, $booking);
            }
        }

        $table["bookings"] = $tableBookings;

        array_push($updatedTableRecords, $table);
    }

    $pageData["restaurantTables"] = $updatedTableRecords;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["tableBookingFormType"]))
{
    if ($_POST["tableBookingFormType"] == SiteUtil::TABLE_BOOKING_PAGE_DELETE)
    {
        $bookingId = $_POST["tableBookingId"];

        $bookingDeleteResponse = json_decode(APIUtil::deleteApiRequest(TableBookingController::API_DELETE . "?tableBookingId=" . $bookingId), true);

        // redirect to this page to reload page data
        if ($bookingDeleteResponse["status"] == APIUtil::DELETE_SUCCESSFUL)
        {
            header("Location: restaurantTableBooking.php");
        }
    }
}

function getDeleteForm($counter, $bookingId) {
    $deleteForm = "<form class='fd-menu-item-delete-form' method='POST' action='restaurantTableBooking.php'>";
    $deleteForm .= "<input type='hidden' name='tableBookingFormType' value='" . SiteUtil::TABLE_BOOKING_PAGE_DELETE . "'>";
    $deleteForm .= "<input type='hidden' name='tableBookingId' value='" . $bookingId . "'>";
    $deleteForm .= "<button type='submit' id='rest-table-delete" . $counter . "' class='btn fd-button'>Delete</button>";
    $deleteForm .= "</form>";

    return $deleteForm;
}


?>

<!doctype html>
<html lang="en">

<?php include "fragments/siteHeader.php"; ?>

<body>

<?php include "fragments/navbar.php" ?>

<div class="container">
    <h1 class="fd-form-page-heading">Eat In Bookings</h1>
    <div class="fd-form-container">

        <div class="d-flex justify-content-between mb-3">
            <p>Here you can see and edit the bookings made for all of the tables available in your restaurant.</p>
            <a class="btn fd-button" href="restaurantTables.php">Tables Edit Page</a>
        </div>

        <?php
            foreach ($pageData["restaurantTables"] as $table) {
                $tableBookingsHtml =  "<div style='margin-bottom: 50px'><h1 class='fd-table-bookings-header'>" . $table["name"] . "</h1>";

                $tableHeader = "<thead><tr>
                    <th scope=\"col\">#</th>
                    <th scope=\"col\">Client Name</th>
                    <th scope=\"col\">Seats Selected</th>
                    <th scope=\"col\">Booking Date</th>
                    <th scope=\"col\"></th>
                </tr></thead>";

                $tableBody = "<tbody>";


                $counter = 1;
                foreach ($table["bookings"] as $booking) {
                    $tableRow = "<tr><th scope=\"row\">" . $counter . "</th>";
                    $tableRow .= "<td>" . $booking["user_id"] . "</td>";
                    $tableRow .= "<td>" . $booking["seats"] . "</td>";
                    $tableRow .= "<td>" . $booking["date"] . "</td>";

                    $tableRow .= "<td>" . getDeleteForm($counter, $booking["id"]) . "</td>";

                    $tableRow .= "</tr>";

                    $tableBody .= $tableRow;

                    $counter += 1;
                }

                $tableBody .= "</tbody>";


                $tableHtml = "<table class='table'>";

                $tableHtml .= $tableHeader;
                $tableHtml .= $tableBody;

                $tableHtml .= "</table>";


                $tableBookingsHtml .= $tableHtml;
                $tableBookingsHtml .= "</div>";

                echo $tableBookingsHtml;
            }
        ?>

    </div>
</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->
<script src="app/table-booking.js"></script>

</body>
</html>
