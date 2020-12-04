<?php

function createToken($payloads)
{
    include('secret_key.php');

    // Secret Key
    $secret = $secret_key;

    $headers = array(
        "typ" => "JWT",
        "alg" => "HS256"
    );

    // Create token header as a JSON string 
    $header = json_encode($headers);

    // Create token payload as a JSON string
    $payload = json_encode($payloads);

    // Encode Header
    $base64UrlHeader = base64UrlEncode($header);

    // Encode Payload
    $base64UrlPayload = base64UrlEncode($payload);

    // Create Signature Hash
    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);

    // Encode Signature to Base64Url String
    $base64UrlSignature = base64UrlEncode($signature);

    // Create JWT
    $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

    return $jwt;
}
