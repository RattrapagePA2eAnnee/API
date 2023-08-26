<?php

function createCourses(string $course_name, string $registration_price, string $hours_minimal): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
        INSERT INTO COURSES(
            course_name,
            registration_price,
            hours_minimal
        ) VALUES (
            :course_name,
            :registration_price,
            :hours_minimal
        );
    ");

    $createUserQuery->execute([
        ":course_name" => htmlspecialchars($course_name),
        ":registration_price" => htmlspecialchars($registration_price),
        ":hours_minimal" => htmlspecialchars($hours_minimal)
    ]);

}
