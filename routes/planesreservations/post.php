<?php

require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/planesreservations/planesreservations.php";
require_once __DIR__ . "/../../libraries/authorization.php";

if (authorization(2)) {
    try {
        $body = getBody();

        $start_time_str = $body["start_time"];
        $end_time_str = $body["end_time"];

        // Convert strings to DateTime objects
        $start_time = new DateTime($start_time_str);
        $end_time = new DateTime($end_time_str);
        
        $reservations = planeReservations($start_time, $end_time);
        if (!empty($reservations)) {
            echo jsonResponse2(200, [], [
                "success" => true,
                "message" => "Voici la liste des reservations par avions",
                "reservations" => $reservations
            ]);
        } else {
            echo jsonResponse2(200, [], [
                "success" => false,
                "message" => "Aucune réservation trouvée pour cette période."
            ]);
        }

    } catch (Exception $exception) {
        echo jsonResponse2(500, [], [
            "success" => false,
            "error" => $exception->getMessage()
        ]);
    }
} else {
    echo jsonResponse2(400, [], [
        "success" => false,
        "error" => "Vous n'avez pas les droit néccessaire pour effectuer cette action"
    ]);
}
