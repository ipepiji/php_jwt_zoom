<?php

include('../api/main.php');
include('../jwt/validate.php');
include('create_token.php');

$token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6IjU4WEpBdGpfUkRLWnVManR3TmdvSVEiLCJleHAiOjE2MDcwOTYwNDksImlhdCI6MTYwNzA5MDY1MH0.5k2flLEa-DvlDGJFZDhgw1RpixyqcA15gCIFoG4xK0k";
$current = 1607091193;

try {
    $response = validateToken($token, $current);
} catch (Exception $e) {
    if ($e->getMessage() === "Token has expired") {
        $token = generateJWT($current);
        $response = json_encode(
            array(
                "new_token" => $token
            )
        );
    } else {
        $response = json_encode(
            array(
                "error" => $e->getMessage()
            )
        );
    }
}

echo $response;

// $zoom_headers = array(
//     "Content-Type" => "application/json",
//     "Authorization" => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOm51bGwsImlzcyI6IjU4WEpBdGpfUkRLWnVManR3TmdvSVEiLCJleHAiOjE2MDcwODI0NDcsImlhdCI6MTYwNzA3NzA0OH0.eDZd5QVBV25gZ-VYkaR9NLA8is2627Ma2aYNgQHx80Q"
// );

// $zoom_data = array(
//     "user" => "ulala",
// );

// $zoom_data = requestAPI('POST', 'https://api.zoom.us/v2/users/{userId}/meetings', $zoom_headers, $zoom_data);
