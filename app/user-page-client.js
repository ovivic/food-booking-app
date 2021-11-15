$(document).ready(function () {

    let addressForm = $('#userpage-address-form');
    addressForm.hide();

    $('#show-address-form').click(function () {
        addressForm.toggle();
    });

});