<?php
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/connectiontokens/get-connection.php";

try {
    $body = getBody();
    
    if (!isset($body["connectoken"])) {
        throw new Exception("Le paramètre 'connectoken' est manquant.");
    }
    
    $connection = getConnection($body["connectoken"]);

    if (!$connection["success"]) {
        throw new Exception($connection["error"]);
    }

    echo jsonResponse(200, ["X-School" => "ESGI"], [
        "success" => true,
        "connection" => $connection
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, [], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
