<?php

require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/parameters.php";
require_once __DIR__ . "/../../entities/parkings/update-parking.php";
require_once __DIR__ . "/../../libraries/authorization.php";


if (authorization(2)){
    try {
        $body = getBody();
        $parameters = getParametersForRoute("/parkings/:parking");
        $id = $parameters["parking"];
    
        updateParkings($id, $body);
    
        echo jsonResponse(200, [], [
            "success" => true,
            "message" => "updated"
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