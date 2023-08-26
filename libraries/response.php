<?php

function jsonResponse($statusCode, $headers, $body)
{
    // Modifie le code de statut
    http_response_code($statusCode);
    
    // On modifie les en-têtes
    foreach ($headers as $headerName => $headerValue) {
        if (!is_string($headerName) || !is_string($headerValue)) {
            throw new Exception('Header name and value must be strings.');
        }
        header("$headerName: $headerValue");
    }

    header("Content-Type: application/json");
    // On renvoie une réponse (contenu)
    return json_encode($body);
}



function jsonResponse2(int $statusCode, $data = [], array $messages = []): string 
{
    header("Content-Type: application/json");
    http_response_code($statusCode);

    // Ensure the data is correctly formatted as a JSON string
    // $dataJson = is_array($data) ? json_encode($data) : $data;
    // $messagesJson = is_array($messages) ? json_encode($messages) : $messages;

    // Build the response
    $response = [
        'data' => $data,
        'messages' => $messages
    ];

    return json_encode($response);
}

