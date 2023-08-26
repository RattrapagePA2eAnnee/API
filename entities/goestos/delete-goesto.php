<?php

function deleteGoesto(string $id_user ,string $id_event): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();
    $deleteUserQuery = $databaseConnection->prepare("DELETE FROM GOESTO WHERE id_user = :id_user AND id_event = :id_event");

    $deleteUserQuery->execute([
        ":id_user" => htmlspecialchars($id_user),
        ":id_event" => htmlspecialchars($id_event)
    ]);
}


