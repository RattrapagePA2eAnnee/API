<?php

function createPlanereservations(string $reservation_id, string $plane_id,string $start_time, string $end_time, string $price, ?string $instructor_id ,string $type): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
        INSERT INTO PLANE_RESERVATION(
            reservation_id,
            plane_id,
            start_time,
            end_time,
            price,
            instructor_id,
            type

        ) VALUES (
            :reservation_id,
            :plane_id,
            :start_time,
            :end_time,
            :price,
            :instructor_id,
            :type
        );
    ");

    $createUserQuery->execute([
        ":reservation_id" => htmlspecialchars($reservation_id),
        ":plane_id" => htmlspecialchars($plane_id),
        ":start_time" => htmlspecialchars($start_time),
        ":end_time" => htmlspecialchars($end_time),
        ":price" => htmlspecialchars($price),
        ":instructor_id" => is_null($instructor_id) ? null : htmlspecialchars($instructor_id),
        ":type" => htmlspecialchars($type)
    ]);

}
