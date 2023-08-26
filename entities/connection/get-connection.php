<?php
function getConnection(string $email, string $password, $user , string $origin): ?array
{
    require_once __DIR__ . "/../../database/connection.php";
    require_once __DIR__ . "/../tokens/delete-token.php";
    require_once __DIR__ . "/../tokens/get-tokens.php";


    // Générer un token unique
    $token = bin2hex(random_bytes(64));

    $beforeToken = getToken(["user_id" => $user[0]['id'],"origin" => $origin]);

    if ($beforeToken !== null && count($beforeToken) > 0) {
        deleteToken($beforeToken[0]['id']);
    }

    // Insérer le token dans la table TOKENS avec l'id de l'utilisateur
    $databaseConnection = getDatabaseConnection();
    $insertTokenQuery = $databaseConnection->prepare("INSERT INTO TOKENS (user_id, token, origin) VALUES (:user_id, :token, :origin);");
    $insertTokenQuery->execute([
        "user_id" => $user[0]['id'],
        "token" => $token,
        "origin" => $origin
    ]);

    $databaseConnection = getDatabaseConnection();
    $insertTokenQuery = $databaseConnection->prepare("DELETE FROM TOKENS
    WHERE creation_time <= NOW() - INTERVAL 24 HOUR;");
    $insertTokenQuery->execute();
    

    // Retourner toutes les informations de l'utilisateur avec le token généré
    return ["connection" => array_merge($user[0], ["token" => $token])];
}


