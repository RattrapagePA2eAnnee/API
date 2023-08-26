<?php

function deleteParkings(string $id): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();
    $deleteUserQuery = $databaseConnection->prepare("DELETE FROM PARKINGS WHERE id = :id");

    $deleteUserQuery->execute([
        "id" => $id
    ]);
}
