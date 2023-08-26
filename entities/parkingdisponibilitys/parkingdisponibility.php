<?php

function parkingDisponibility(int $wingspan, int $length, string $type, DateTime $startTime, DateTime $endTime): array
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    // if the parking type is not 'exterior', take wingspan and length into consideration
    if ($type !== 'exterior') {
        $parkingQuery = $databaseConnection->prepare(
            "SELECT id, parking_number 
            FROM PARKINGS 
            WHERE type = :type 
            AND wingspan >= :wingspan 
            AND length >= :length"
        );

        $parkingQuery->execute([
            'type' => $type,
            'wingspan' => $wingspan,
            'length' => $length
        ]);
    } else {
        $parkingQuery = $databaseConnection->prepare(
            "SELECT id, parking_number 
            FROM PARKINGS 
            WHERE type = :type"
        );

        $parkingQuery->execute(['type' => $type]);
    }

    $parkings = $parkingQuery->fetchAll(PDO::FETCH_ASSOC);

    if (empty($parkings)) {
        return []; // no matching parkings
    }

    $availableParkings = [];

    foreach ($parkings as $parking) {
        $reservationQuery = $databaseConnection->prepare(
            "SELECT COUNT(*) as reserved_count
            FROM PARKING_RESERVATION
            WHERE parking_id = :parking_id
            AND (
                (:start_time BETWEEN start_time AND end_time)
                OR (:end_time BETWEEN start_time AND end_time)
                OR (start_time BETWEEN :start_time AND :end_time)
                OR (end_time BETWEEN :start_time AND :end_time)
            )"
        );

        $reservationQuery->execute([
            'parking_id' => $parking['id'],
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => $endTime->format('Y-m-d H:i:s')
        ]);

        $reservation = $reservationQuery->fetch(PDO::FETCH_ASSOC);

        if ($reservation['reserved_count'] == 0) {
            $availableParkings[] = [
                'id' => $parking['id'],
                'parking_number' => $parking['parking_number']
            ];
        }
    } 

    return $availableParkings;
}
