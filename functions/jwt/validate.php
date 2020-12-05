<?php

include('base64UrlEncode.php');

function validateToken($token, $current)
{
    include('env.php');

    // Get the secret key
    $secret = $secret_key;

    if (!isset($token)) {
        throw new Exception("Token not provided");
    } else {
        $jwt = $token;

        // Split the token
        $tokenParts = explode('.', $jwt);
        if (count($tokenParts) === 3) {
            $header = base64_decode($tokenParts[0]);
            $payload = base64_decode($tokenParts[1]);
            $signatureProvided = $tokenParts[2];

            // Check the expiration time - note this will cause an error if there is no 'exp' claim in the token
            if (isset(json_decode($payload)->exp)) {
                $expiration = (int)(json_decode($payload)->exp);
                $current_datetime = (int)$current;
                if ($current_datetime > $expiration) {
                    throw new Exception("Token has expired");
                } else {
                    // Build a signature based on the header and payload using the secret
                    $base64UrlHeader = base64UrlEncode($header);
                    $base64UrlPayload = base64UrlEncode($payload);
                    $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);
                    $base64UrlSignature = base64UrlEncode($signature);

                    // Verify it matches the signature provided in the token
                    $signatureValid = ($base64UrlSignature === $signatureProvided);

                    if (!$signatureValid) {
                        throw new Exception("The signature is NOT valid");
                    } else {
                        return $payload;
                    }
                }
            } else {
                throw new Exception("No expiration date");
            }
        } else {
            throw new Exception("Not JWT token");
        }
    }
}
