<?php

include('../jwt/generate.php');

function generateJWT($current)
{
    $api_key = "58XJAtj_RDKZuLjtwNgoIQ";

    $payloads = array(
        "aud" => null,
        "iss" => $api_key,
        "exp" => (int)$current + 604800,
        "iat" => (int)$current
    );

    $token = createToken($payloads);

    return $token;
}
