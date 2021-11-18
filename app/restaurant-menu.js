$(document).ready(function () {

    $("button[id^=menu-item-delete]").click(function () {
        confirm("Are you sure you want to delete this item?");
    });

});