$(document).ready(function(){
    showRegistrationForm();

    $(document).on('click', '#register-user-button', function(){

        let form_data = {
            "name":  $('input#full-name').val(),
            "email": $('input#email-address').val(),
            "username": $('input#username').val(),
            "password": $('input#password').val()
        }

        form_data=JSON.stringify(form_data);

        console.log(form_data);

        // submit form data to api
        $.ajax({
            url: "http://localhost/food_booking_app/api/user/create.php",
            type : "POST",
            contentType : 'application/json',
            data : form_data,
            success : function(result) {
                // product was created, go back to products list
                console.log("User Created")
            },
            error: function(xhr, resp, text) {
                // show error to console
                console.log(xhr, resp, text);
            }
        });

        return false;
    });
});



function showRegistrationForm() {
    let formHtml = `
        <form id="user-registration-form">
            <div class="form-group">
                <label for="full-name">Name</label>
                <input type="text" class="form-control" id="full-name" placeholder="Enter your name">
            </div>
            <div class="form-group">
                <label for="email-address">Email address</label>
                <input type="email" class="form-control" id="email-address" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <button type="button" class="btn btn-primary" id="register-user-button">Submit</button>
        </form>
    `;

    $("#page-content").html(formHtml);

    changePageTitle("Registration");
}
