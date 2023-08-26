<?php

// Récupérer des données depuis le corps de la requête
// Faire une requête SQL pour créer un utilisateur
// Renvoyer une réponse (succès, echec) à l'utilisateur de l'API

require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/planedisponibility/planedisponibility.php";
require_once __DIR__ . "/../../libraries/authorization.php";


if (authorization(2)){

    try {
        $body = getBody();

    $start_time_str = $body["start_time"];
    $end_time_str = $body["end_time"];

    // Create DateTime objects from strings
    $start_time = new DateTime($start_time_str);
    $end_time = new DateTime($end_time_str);
    
       if(planeDisponibility($body["plane_id"], $start_time, $end_time)){
        echo jsonResponse(200, [], [
            "success" => true,
            "message" => "créneau disponible"
        ]);
       }else{
        echo jsonResponse(200, [], [
            "success" => false,
            "message" => "créneau indisponible"
        ]);
       }
    
 
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