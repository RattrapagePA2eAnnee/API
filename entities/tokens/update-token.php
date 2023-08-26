<?php

function updateToken(string $id, $columns): void
{
    if (count($columns) === 0) {
        return;
    }

    require_once __DIR__ . "/../../database/connection.php";

    $authorizedColumns = ["id", "user_id", "token", "creation_time","origin"];

    $set = [];

    $sanitizedColumns = [
        "id" => htmlspecialchars($id)
    ];

    foreach ($columns as $columnName => $columnValue) {
        if (!in_array($columnName, $authorizedColumns)) {
            continue;
        }

        $set[] = "$columnName = :$columnName";

        $sanitizedColumns[$columnName] = htmlspecialchars($columnValue);
    }

    $set = implode(", ", $set);

    $databaseConnection = getDatabaseConnection();
    $updateUserQuery = $databaseConnection->prepare("UPDATE TOKENS SET $set WHERE id = :id;");
    $updateUserQuery->execute($sanitizedColumns);
}
