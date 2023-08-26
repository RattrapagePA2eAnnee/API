<?php

function deleteServices(string $id): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();
    $deleteUserQuery = $databaseConnection->prepare("DELETE FROM SERVICES WHERE id = :id");

    $deleteUserQuery->execute([
        "id" => $id
    ]);
}
