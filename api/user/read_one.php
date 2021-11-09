<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

require __DIR__ . "/../../config/main.php";

$user = new UserModel();
$user->id = isset($_GET['id']) ? $_GET['id'] : die();

$user->readOne();

if ($user->name != null)
{
    $user_array = [
        "id" => $user->id,
        "name" => $user->name,
        "email" => $user->email,
        "username" => $user->username,
        "password" => $user->password,
        "salt" => $user->salt,
        "type" => $user->type,
    ];

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($user_array);
}

else{
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "User does not exist."));
}
?>