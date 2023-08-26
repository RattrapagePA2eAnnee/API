<?php

function deleteUser(string $id): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();
    $deleteUserQuery = $databaseConnection->prepare("DELETE FROM USERS WHERE id = :id");

    $deleteUserQuery->execute([
        "id" => $id
    ]);
}
