<?php

function createToken(string $user_id, string $token): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
    INSERT INTO TOKENS (user_id, token, origin) VALUES (:user_id, :token , origin);"
    );

    $createUserQuery->execute([
        ":user_id" => htmlspecialchars($user_id),
        ":token" => htmlspecialchars($token)
    ]);
}
