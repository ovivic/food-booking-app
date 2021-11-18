$(document).ready(function () {

    $("button[id^=rest-table-delete]").click(function () {
        confirm("Are you sure you want to delete this item?");
    });

});