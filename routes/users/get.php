<?php
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/users/get-users.php";
require_once __DIR__ . "/../../libraries/authorization.php";


if (authorization(2)){

    try {

        $body = getBody();
        $users = getUser($body);
    
        echo jsonResponse(200, ["X-School" => "ESGI"], [
            "success" => true,
            "users" => $users
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