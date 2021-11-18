$(document).ready(function () {

    $("button[id^=rest-table-delete]").click(function () {
        confirm("Are you sure you want to delete this item?");
    });

    let addressForm = $('#userpage-address-form');
    addressForm.hide();

    $('#show-address-form').click(function () {
        addressForm.toggle();
    });

});