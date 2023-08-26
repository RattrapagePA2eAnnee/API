<?php

function createPlanes(string $horometer, string $plane_name, string $plane_type, string $hourly_price): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
        INSERT INTO PLANES(
            horometer,
            plane_name,
            plane_type,
            hourly_price
        ) VALUES (
            :horometer,
            :plane_name,
            :plane_type,
            :hourly_price
        );
    ");

    $createUserQuery->execute([
        ":horometer" => htmlspecialchars($horometer),
        ":plane_name" => htmlspecialchars($plane_name),
        ":plane_type" => htmlspecialchars($plane_type),
        ":hourly_price" => htmlspecialchars($hourly_price)
    ]);

}
