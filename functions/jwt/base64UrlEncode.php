<?php

function base64UrlEncode($text)
{
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
}
