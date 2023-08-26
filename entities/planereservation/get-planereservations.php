<?php

function getPlanereservations(?array $columns = null): array
{
    if (!is_array($columns)) {
        $columns = [];
    }

    require_once __DIR__ . "/../../database/connection.php";

    $authorizedColumns = ["reservation_id", "plane_id", "start_time", "end_time","price","instructor_id","status","type"];

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
    $getUserQuery = $databaseConnection->prepare("SELECT * FROM PLANE_RESERVATION WHERE $whereClause;");
    $getUserQuery->execute($sanitizedColumns);

    $users = $getUserQuery->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}
