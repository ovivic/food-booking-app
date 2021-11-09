<?php
require __DIR__ . "/config/main.php";

//define("MAIN_ROOT", __DIR__ . "/config/main.php");

//var_dump(PROJECT_ROOT_PATH);

//echo "Test";

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Homepage</title>
</head>
<body>

<div class="container">
    <h1>User Registration</h1>
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
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
    $(document).ready(function(){

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
</script>


</body>
</html>
