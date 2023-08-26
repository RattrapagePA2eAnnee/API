<?php

function getUser(?array $columns = null): array
{
    if (!is_array($columns)) {
        $columns = [];
    }

    require_once __DIR__ . "/../../database/connection.php";

    $authorizedColumns = ["id", "last_name", "first_name", "password", "email", "role", "subscription_status", "profile_picture", "birth_date","account_creation_time","address","postal_code","city"];

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
    $getUserQuery = $databaseConnection->prepare("SELECT * FROM USERS WHERE $whereClause;");
    $getUserQuery->execute($sanitizedColumns);

    $users = $getUserQuery->fetchAll(PDO::FETCH_ASSOC);

    return $users;
}

