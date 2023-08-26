<?php

function getPlanes(?array $columns = null): array
{
    if (!is_array($columns)) {
        $columns = [];
    }

    require_once __DIR__ . "/../../database/connection.php";

    $authorizedColumns = ["id", "picture", "horometer", "plane_name", "plane_type", "hourly_price"];

    $where = [];
    $sanitizedColumns = [];

    foreach ($columns as $columnName => $columnValue) {
        if (!in_array($columnName, $authorizedColumns)) {
            continue;
        }

        $where[] = "$columnName = :$columnName";
        $sanitizedColumns[$columnName] = htmlspecialchars($columnValue);
    }

    $whereClause = count($where) > 0 ? implode(" AND ", $where) : "1";

    $databaseConnection = getDatabaseConnection();
    $getUserQuery = $databaseConnection->prepare("SELECT * FROM PLANES WHERE $whereClause;");
    $getUserQuery->execute($sanitizedColumns);

    $users = $getUserQuery->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}

