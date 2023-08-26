<?php

function createServicereservations(string $reservation_id, string $service_id, string $datetime): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
        INSERT INTO SERVICE_RESERVATION(
            reservation_id,
            service_id,
            datetime

        ) VALUES (
            :reservation_id,
            :service_id,
            :datetime
        );
    ");

    $createUserQuery->execute([
        ":reservation_id" => htmlspecialchars($reservation_id),
        ":service_id" => htmlspecialchars($service_id),
        ":datetime" => htmlspecialchars($datetime)
    ]);

}
