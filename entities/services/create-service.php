<?php

function createServices(string $service_name, string $description, string $price): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
        INSERT INTO SERVICES(
            service_name,
            description,
            price
        ) VALUES (
            :service_name,
            :description,
            :price
        );
    ");

    $createUserQuery->execute([
        ":service_name" => htmlspecialchars($service_name),
        ":description" => htmlspecialchars($description),
        ":price" => htmlspecialchars($price)
    ]);

}
