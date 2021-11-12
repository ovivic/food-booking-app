// switch the active button on the registration form
$(document).on("click", ".fd-usertype-selection-button", function () {
    let hiddenInput = $("input#fd-registration-account-type");

    // set the value of the hidden input
    if ($(this).text() === "Client") { // 1 if client account
        hiddenInput.val(1);
    } else if ($(this).text() === "Restaurant") { // 2 if restaurant account
        hiddenInput.val(2)
    }

    $(".fd-usertype-selection-button").each(function () {
        $(this).removeClass("active");
    });

    $(this).addClass("active");
});

$(document).ready(function () {
    let hiddenInput = $("input#fd-registration-account-type");

    // if the page has been reloaded and there is a value selected for the hidden input
    if (hiddenInput.val() !== 0) {
        $('#fd-registration-buttons').children().eq(hiddenInput.val() - 1).addClass('active');
    }
});