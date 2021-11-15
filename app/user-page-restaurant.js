$(document).ready(function () {

    // disable restaurant form when loading page
    let isDisabled = true;

    $("[id^=rest-]").each(function () {
        $(this).prop("disabled", isDisabled)
    })

    $('#restaurant-form-submit').prop("disabled", isDisabled);

    $



    $('#restaurant-form-enable').click(function () {
        isDisabled = !isDisabled;

        $("[id^=rest-]").each(function () {
            $(this).prop("disabled", isDisabled)
        })

        $('#restaurant-form-submit').prop("disabled", isDisabled);

        $(this).html(getButtonName(isDisabled));
    });

});

function getButtonName(formStatus) {
    if (formStatus === true) {
        return "Enable Form";
    }

    return "Disable Form"
}