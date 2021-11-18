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

// table-delete form variables
$restTableDeleteFormError = false;

// table-add form variable
$restTableName = $restTableSeats = '';
$isErrorRestTableAdd = false;
$restTableAddError = false;


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["restTablesFormType"]))
{
    if ($_POST["restTablesFormType"] == SiteUtil::RESTAURANT_TABLES_PAGE_DELETE_TABLE)
    {
        $restTableId = $_POST["restTableId"];

        $tableDeleteResponse = json_decode(APIUtil::deleteApiRequest(RestaurantTableController::API_DELETE . "?restTableId=" . $restTableId), true);

        // redirect to this page to reload page data
        if ($tableDeleteResponse["status"] == APIUtil::DELETE_SUCCESSFUL)
        {
            header("Location: restaurantTables.php");
        }
        else
        {
            $restTableDeleteFormError = true;
        }
    }

    if ($_POST["restTablesFormType"] == SiteUtil::RESTAURANT_TABLES_PAGE_ADD_TABLE)
    {
        if (empty($_POST["restTableName"])) {
            $isErrorRestTableAdd = true;
        } else {
            $restTableName = APIUtil::prepareValueForApi($_POST["restTableName"]);
        }

        if (empty($_POST["restTableMaxSeats"])) {
            $isErrorRestTableAdd = true;
        } else {
            $restTableSeats = APIUtil::prepareValueForApi($_POST["restTableMaxSeats"]);
        }

        if (!$isErrorRestTableAdd) {
            $restTableFormData = [
                "restaurant_id" => $pageData["restaurant"]["id"],
                "name" => $restTableName,
                "max_seats" => $restTableSeats
            ];

            var_dump($restTableFormData);
            var_dump(json_encode($restTableFormData));

            $restTableAddResponse = json_decode(APIUtil::postApiRequest(RestaurantTableController::API_CREATE, json_encode($restTableFormData)), true);

            if (isset($restTableAddResponse["status"]) == APIUtil::CREATE_SUCCESSFUL)
            {
                header("Location: restaurantTables.php");
            }
            else
            {
                $restTableAddError = true;
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
    <h1 class="fd-form-page-heading">Tables Set Up</h1>
    <div class="fd-form-container">

        <div class="d-flex justify-content-between mb-3">
            <p>Complete the form to add a table. After adding it will appear in the table bellow.</p>
            <div>
                <a class="btn fd-button" href="restaurantTableBooking.php"><i class="bi bi-folder"></i> View Table Bookings</a>
                <a class="btn fd-button" href="userPageRestaurant.php">Restaurant Page</a>
            </div>

        </div>

        <?php if ($restTableDeleteFormError) { ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-x-circle"></i> There has been an issue when deleting the table record.
            </div>
        <?php } ?>

        <?php if ($restTableAddError) { ?>
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-x-circle"></i> There has been an issue when adding the table
            </div>
        <?php } ?>

        <form action="restaurantTables.php" method="POST">
            <input type='hidden' name='restTablesFormType' value="<?php echo SiteUtil::RESTAURANT_TABLES_PAGE_ADD_TABLE ?>">

            <div class="form-row align-items-center mb-2">
                <div class="col-auto">
                    <input type="text" class="form-control" name="restTableName" placeholder="Table Name" value="<?php echo (isset($_POST["restTableName"]) && $_POST["restTableName"]) ? $_POST["restTableName"] : '' ?>" required>
                </div>

                <div class="col-auto">
                    <select class="form-control" name="restTableMaxSeats" required>
                        <option value="0">Choose seats...</option>
                        <option value="1">1 Seat</option>
                        <option value="2">2 Seats</option>
                        <option value="3">3 Seats</option>
                        <option value="4">4 Seats</option>
                        <option value="5">5 Seats</option>
                        <option value="6">6 Seats</option>
                        <option value="7">7 Seats</option>
                        <option value="8">8 Seats</option>
                    </select>
                </div>

                <div class="col-auto">
                    <button type='submit' id='menu-item-add' class='btn fd-button'>Add Item</button>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Table Name</th>
                <th scope="col">Max Seats</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                foreach ($pageData["restaurantTables"] as $restTable)
                {
                    $tableRow = "<tr><th scope=\"row\">" . $counter . "</th>";
                    $tableRow .= "<td>" . $restTable["name"] . "</td>";

                    $tableRow .= "<td>" . $restTable["max_seats"] . "</td>";

                    $deleteForm = "<form class='fd-menu-item-delete-form' method='POST' action='restaurantTables.php'>";
                    $deleteForm .= "<input type='hidden' name='restTablesFormType' value='" . SiteUtil::RESTAURANT_TABLES_PAGE_DELETE_TABLE . "'>";
                    $deleteForm .= "<input type='hidden' name='restTableId' value='" . $restTable["id"] . "'>";
                    $deleteForm .= "<button type='submit' id='rest-table-delete" . $counter . "' class='btn fd-button'>Delete</button>";
                    $deleteForm .= "</form>";

                    $tableRow .= "<td>" . $deleteForm . "</td>";

                    echo $tableRow;

                    $counter += 1;
                }

                ?>
            </tbody>
        </table>

    </div>
</div>

<?php include "fragments/footer.php"; ?>

<?php include "fragments/siteScripts.php"; ?>

<!--  add any custom scripts for this page here  -->
<script src="app/restaurant-tables.js"></script>

</body>
</html>
