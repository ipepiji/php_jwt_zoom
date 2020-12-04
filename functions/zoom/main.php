<?php

include('../api/main.php');
include('../jwt/validate.php');
include('create_token.php');

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6IjU4WEpBdGpfUkRLWnVManR3TmdvSVEiLCJleHAiOjE2MDcwOTYwNDksImlhdCI6MTYwNzA5MDY1MH0.5k2flLEa-DvlDGJFZDhgw1RpixyqcA15gCIFoG4xK0k";
$current = 1607096049;

try {
    $response = validateToken($token, $current);
    echo $response;
} catch (Exception $e) {
    if ($e->getMessage() === "Token has expired") {
        $token = generateJWT($current);
        $new_token = array(
            "new_token" => $token
        );
        echo json_encode($new_token);
    } else {
        $error_message = array(
            "error" => $e->getMessage()
        );
        echo json_encode($error_message);
    }
}

// $zoom_headers = array(
//     "Content-Type" => "application/json",
//     "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6IjU4WEpBdGpfUkRLWnVManR3TmdvSVEiLCJleHAiOjE2MDcwODI0NDcsImlhdCI6MTYwNzA3NzA0OH0.eDZd5QVBV25gZ-VYkaR9NLA8is2627Ma2aYNgQHx80Q"
// );

// $zoom_data = array(
//     "user" => "ulala",
// );

// $zoom_data = requestAPI('POST', 'https://api.zoom.us/v2/users/{userId}/meetings', $zoom_headers, $zoom_data);
