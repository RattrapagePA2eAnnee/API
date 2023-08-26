<?php

function createCourseparticipations(string $user_id, string $course_id): void
{
    require_once __DIR__ . "/../../database/connection.php";

    $databaseConnection = getDatabaseConnection();

    $createUserQuery = $databaseConnection->prepare("
        INSERT INTO COURSE_PARTICIPATION(
            user_id,
            course_id,
            participation_date_time
        ) VALUES (
            :user_id,
            :course_id,
            CURRENT_TIMESTAMP
        );
    ");

    $createUserQuery->execute([
        ":user_id" => htmlspecialchars($user_id),
        ":course_id" => htmlspecialchars($course_id)
    ]);

}
