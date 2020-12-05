<?php

include('../api/main.php');
include('../jwt/validate.php');
include('create_token.php');

$token = $_POST['token'];
$current = $_POST['current'];

try {
    $response = validateToken($token, $current);
} catch (Exception $e) {
    if ($e->getMessage() === "Token has expired") {
        $new_token = generateJWT($current);
        $response = validateToken($new_token, $current);
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
