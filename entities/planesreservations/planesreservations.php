<?php

function planeReservations(DateTime $startTime, DateTime $endTime): array
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    // Retrieve all distinct planes with reservations within the given timeframe
    $query = $databaseConnection->prepare(
        "SELECT DISTINCT p.plane_name, p.id AS plane_id
        FROM PLANE_RESERVATION pr
        JOIN PLANES p ON pr.plane_id = p.id
        WHERE (
            (:start_time BETWEEN pr.start_time AND pr.end_time)
            OR (:end_time BETWEEN pr.start_time AND pr.end_time)
            OR (pr.start_time BETWEEN :start_time AND :end_time)
            OR (pr.end_time BETWEEN :start_time AND :end_time)
        )"
    );

    $query->execute([
        'start_time' => $startTime->format('Y-m-d H:i:s'),
        'end_time' => $endTime->format('Y-m-d H:i:s')
    ]);

    $planes = $query->fetchAll(PDO::FETCH_ASSOC);

    $result = [];

    // For each plane, get reservation details
    foreach ($planes as $plane) {
        $plane_id = $plane['plane_id'];
        $plane_name = $plane['plane_name'];

        $reservationQuery = $databaseConnection->prepare(
            "SELECT start_time, end_time
            FROM PLANE_RESERVATION
            WHERE plane_id = :plane_id
            AND (
                (:start_time BETWEEN start_time AND end_time)
                OR (:end_time BETWEEN start_time AND end_time)
                OR (start_time BETWEEN :start_time AND :end_time)
                OR (end_time BETWEEN :start_time AND :end_time)
            )"
        );

        $reservationQuery->execute([
            'plane_id' => $plane_id,
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => $endTime->format('Y-m-d H:i:s')
        ]);

        $reservations = $reservationQuery->fetchAll(PDO::FETCH_ASSOC);
        $result[$plane_name] = $reservations;  // Use the plane name as the key instead of plane_id
    }

    return $result;
}
