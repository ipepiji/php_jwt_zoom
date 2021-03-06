<?php

include('../api/main.php');
include('../jwt/env.php');

$access_token = $_POST['access_token'];
$refresh_token = $_POST['refresh_token'];

$topic = $_POST['topic'];
$start_time = $_POST['start_time'];
$duration = $_POST['duration'];
$password = $_POST['password'];
$timezone = $_POST['timezone'];

try {
    // Create meeting
    $response = zoom_create_meeting($access_token, $topic, $start_time, $duration, $password, $timezone);
    if (isset(json_decode($response, true)['code'])) {
        if (json_decode($response, true)['message'] === "Access token is expired.") {
            $new_access_token = zoom_refresh_token($refresh_token, $client_id, $secret_key);
            $response = zoom_create_meeting($new_access_token, $topic, $start_time, $duration, $password, $timezone);
        }
    }

    // // Delete meeting
    // $meeting_id = json_decode($response, true)['id'];
    // $response = zoom_delete_meeting($access_token, $meeting_id);
    // if (isset(json_decode($response, true)['code'])) {
    //     if (json_decode($response, true)['message'] === "Access token is expired.") {
    //         $response = zoom_refresh_token($refresh_token, $client_id, $secret_key);
    //         $new_access_token = json_decode($response, true)['access_token'];
    //         $response = zoom_delete_meeting($new_access_token, $meeting_id);
    //     }
    // }

    // // Refresh Token
    // $response = zoom_refresh_token($refresh_token, $client_id, $secret_key);
} catch (Exception $e) {
    $response = json_encode(
        array(
            "error" => $e->getMessage()
        )
    );
}

echo $response;

function zoom_create_meeting($access_token, $topic, $start_time, $duration, $password, $timezone)
{
    $url = "https://api.zoom.us/v2/users/me/meetings";
    $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer $access_token"
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

function zoom_delete_meeting($access_token, $meeting_id)
{
    $url = "https://api.zoom.us/v2/meetings/$meeting_id";
    $headers = array(
        "Authorization: Bearer $access_token"
    );
    $result = requestAPI('DELETE', $url, $headers, null);
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
