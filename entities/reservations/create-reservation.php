<?php

function createReservations(string $total_price, string $user_id): int
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createReservationQuery = $databaseConnection->prepare("
        INSERT INTO RESERVATIONS(
            reservation_date,
            total_price,
            user_id
        ) VALUES (
            CURRENT_TIMESTAMP,
            :total_price,
            :user_id
        );
    ");

    $createReservationQuery->execute([
        ":total_price" => htmlspecialchars($total_price),
        ":user_id" => htmlspecialchars($user_id)
    ]);

    // Return the last inserted ID
    return (int) $databaseConnection->lastInsertId();
}

