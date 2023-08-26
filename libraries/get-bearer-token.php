<?php

function getBearerToken() {
    $headers = apache_request_headers();
    $token = isset($headers['Authorization']) ? $headers['Authorization'] : null;
    $token = str_replace('Bearer ', '', $token);
    return $token;
}