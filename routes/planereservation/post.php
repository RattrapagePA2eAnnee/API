<?php

// Récupérer des données depuis le corps de la requête
// Faire une requête SQL pour créer un utilisateur
// Renvoyer une réponse (succès, echec) à l'utilisateur de l'API

require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/planereservation/create-planereservation.php";
require_once __DIR__ . "/../../libraries/authorization.php";


if (authorization(2)){

    try {
        $body = getBody();

        $instructeur = isset($body["instructor_id"]) ? $body["instructor_id"] : null;
    
        createPlanereservations($body["reservation_id"], $body["plane_id"], $body["start_time"], $body["end_time"], $body["price"],$instructeur, $body["type"] );
    
        echo jsonResponse(200, [], [
            "success" => true,
            "message" => "planereservation créé"
        ]);
    } catch (Exception $exception) {
        echo jsonResponse(500, [], [
            "success" => false,
            "error" => $exception->getMessage()
        ]);
    }



}else{
    echo jsonResponse(400, [], [
        "success" => false,
        "error" => "Vous n'avez pas les droit néccessaire pour effectuer cette action"
    ]);
}