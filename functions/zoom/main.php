<?php

include('../api/main.php');
include('../jwt/env.php');

$token = $_POST['token'];
$refresh_token = $_POST['refresh_token'];

$topic = $_POST['topic'];
$start_time = $_POST['start_time'];
$duration = $_POST['duration'];
$password = $_POST['password'];
$timezone = $_POST['timezone'];

try {
    $response = zoom_create_meeting($token, $topic, $start_time, $duration, $password, $timezone);
    if (isset(json_decode($response, true)['code'])) {
        echo "refresh_token" . $response;
        $new_token = zoom_refresh_token($refresh_token, $client_id, $secret_key);
        $response = zoom_create_meeting($new_token, $topic, $start_time, $duration, $password, $timezone);
    }
} catch (Exception $e) {
    $response = json_encode(
        array(
            "error" => $e->getMessage()
        )
    );
}

echo $response;

function zoom_create_meeting($token, $topic, $start_time, $duration, $password, $timezone)
{
    $url = "https://api.zoom.us/v2/users/me/meetings";
    $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer $token"
    );
    $data = array(
        "topic" => $topic,
        "type" => 2,
        "start_time" => $start_time,
        "duration" => $duration,
        "password" => $password,
        "timezone" => $timezone,
        "settings" => array(
            "mute_upon_entry" => true,
            "join_before_host" => true,
            "registrants_email_notification" => true
        )
    );
    $result = requestAPI('POST', $url, $headers, $data);
    return $result;
}

function zoom_refresh_token($refresh_token, $client_id, $secret_key)
{
    $url = "https://zoom.us/oauth/token?grant_type=refresh_token&refresh_token=$refresh_token";
    $headers = array(
        "Authorization: Basic " . base64_encode($client_id . ':' . $secret_key)
    );
    $result = requestAPI('POST', $url, $headers, null);
    return $result;
}
