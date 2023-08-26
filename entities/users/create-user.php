<?php

function createUser(string $last_name, string $first_name, string $password, string $email, string $birth_date): string
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
        INSERT INTO USERS(
            last_name,
            first_name,
            password,
            email,
            birth_date,
            account_creation_time
        ) VALUES (
            :last_name,
            :first_name,
            :password,
            :email,
            :birth_date,
            CURRENT_TIMESTAMP
        );
    ");

    $createUserQuery->execute([
        ":last_name" => htmlspecialchars($last_name),
        ":first_name" => htmlspecialchars($first_name),
        ":email" => htmlspecialchars($email),
        ":birth_date" => htmlspecialchars($birth_date),
        ":password" => password_hash(htmlspecialchars($password), PASSWORD_BCRYPT)
    ]);

    $userId = $databaseConnection->lastInsertId();
    return $userId;
}
