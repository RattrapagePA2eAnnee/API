<?php

function createParkings(string $parking_number, string $type, ?string $length, ?string $wingspan ): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
        INSERT INTO PARKINGS(
            parking_number,
            type,
            length,
            wingspan
        ) VALUES (
            :parking_number,
            :type,
            :length,
            :wingspan
        );
    ");

    $createUserQuery->execute([
        ":parking_number" => htmlspecialchars($parking_number),
        ":type" => htmlspecialchars($type),
        ":length" => is_null($length) ? null : htmlspecialchars($length),
        ":wingspan" => is_null($wingspan) ? null : htmlspecialchars($wingspan)
    ]);
    

}
