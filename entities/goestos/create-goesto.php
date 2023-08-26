<?php

function createGoesto(string $id_user, string $id_event): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
    INSERT INTO GOESTO (id_user, id_event) VALUES
    (:id_user, :id_event);
    ");

    $createUserQuery->execute([
        ":id_user" => htmlspecialchars($id_user),
        ":id_event" => htmlspecialchars($id_event)
    ]);
}
