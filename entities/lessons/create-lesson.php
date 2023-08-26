<?php

function createLessons(string $description, string $content): string
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
        INSERT INTO LECON(
            description,
            content
        ) VALUES (
            :description,
            :content
        );
    ");

    $createUserQuery->execute([
        ":description" => htmlspecialchars($description),
        ":content" => htmlspecialchars($content)
    ]);

    $userId = $databaseConnection->lastInsertId();
    return $userId;
}
