<?php

// Récupérer des données depuis le corps de la requête
// Faire une requête SQL pour créer un utilisateur
// Renvoyer une réponse (succès, echec) à l'utilisateur de l'API

require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/reservations/create-reservation.php";
require_once __DIR__ . "/../../libraries/authorization.php";


if (authorization(2)) {

    try {
        $body = getBody();
    
        // Capture the returned last inserted ID
        $lastInsertedId = createReservations($body["total_price"], $body["user_id"]);
    
        echo jsonResponse(200, [], [
            "success" => true,
            "message" => "Reservations créé",
            "lastInsertedId" => $lastInsertedId  // Include the last inserted ID in the response
        ]);
    } catch (Exception $exception) {
        echo jsonResponse(500, [], [
            "success" => false,
            "error" => $exception->getMessage()
        ]);
    }

} else {
    echo jsonResponse(400, [], [
        "success" => false,
        "error" => "Vous n'avez pas les droits nécessaires pour effectuer cette action"
    ]);
}
