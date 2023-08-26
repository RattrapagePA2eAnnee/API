<?php

function getConnection(string $token): array
{
    require_once __DIR__ . "/../../database/connection.php";
    require_once __DIR__ . "/../tokens/get-tokens.php";

    $databaseConnection = getDatabaseConnection();
    $insertTokenQuery = $databaseConnection->prepare("DELETE FROM TOKENS
    WHERE creation_time <= NOW() - INTERVAL 24 HOUR;");
    $insertTokenQuery->execute();


    $tokenData = getToken(["token" => $token]);

    if (empty($tokenData) || !isset($tokenData[0]['token'])) {
        return ["success" => false, "role" => null, "error" => "Token inexistant dans la BDD"];
    }

    $current_time = time();
    $token_creation_time = strtotime($tokenData[0]['creation_time']);
    $time_elapsed = $current_time - $token_creation_time;
    $time_elapsed_hours = $time_elapsed / 3600;

    
    if ($time_elapsed_hours < 24) {
        $databaseConnection = getDatabaseConnection();
        $selectRoleQuery = $databaseConnection->prepare("SELECT role FROM USERS WHERE id = :id;");
        $selectRoleQuery->execute([
            "id" => $tokenData[0]['user_id'],
        ]);
        $userData = $selectRoleQuery->fetch(); // Récupère le rôle directement depuis la requête
    
        $role = isset($userData['role']) ? $userData['role'] : null; 


        return ["success" => true, "role" => $role];
    } else {
        $databaseConnection = getDatabaseConnection();
        $insertTokenQuery = $databaseConnection->prepare("DELETE FROM TOKENS WHERE token = :token;");
        $insertTokenQuery->execute([
            "token" => $tokenData[0]['token'],
        ]);
        return ["success" => false, "user_id" => null, "error" => "Token expiré"];
    }
}


