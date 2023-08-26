<?php

function createParkingreservations(string $reservation_id, string $parking_id,string $start_time, string $end_time, string $price): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
        INSERT INTO PARKING_RESERVATION(
            reservation_id,
            parking_id,
            start_time,
            end_time,
            price

        ) VALUES (
            :reservation_id,
            :parking_id,
            :start_time,
            :end_time,
            :price
        );
    ");

    $createUserQuery->execute([
        ":reservation_id" => htmlspecialchars($reservation_id),
        ":parking_id" => htmlspecialchars($parking_id),
        ":start_time" => htmlspecialchars($start_time),
        ":end_time" => htmlspecialchars($end_time),
        ":price" => htmlspecialchars($price)
    ]);

}
