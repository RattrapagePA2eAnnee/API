<?php

function planeDisponibility(int $plane_id, DateTime $startTime, DateTime $endTime): bool
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $query = $databaseConnection->prepare(
        "SELECT *
        FROM PLANE_RESERVATION
        WHERE plane_id = :plane_id
        AND (
            (:start_time BETWEEN start_time AND end_time)
            OR (:end_time BETWEEN start_time AND end_time)
            OR (start_time BETWEEN :start_time AND :end_time)
            OR (end_time BETWEEN :start_time AND :end_time)
        )"
    );

    $query->execute([
        'plane_id' => $plane_id,
        'start_time' => $startTime->format('Y-m-d H:i:s'),
        'end_time' => $endTime->format('Y-m-d H:i:s')
    ]);

    // fetch the result
    $reservations = $query->fetchAll(PDO::FETCH_ASSOC);

    // if there are any results then the slot is not available
    return count($reservations) === 0;
}
