<?php
require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/authorization.php";
require_once __DIR__ . "/../../database/connection.php";

if (!authorization(2)) {
    echo jsonResponse(400, [], [
        "success" => false,
        "error" => "Vous n'avez pas les droits nécessaires pour effectuer cette action"
    ]);
    exit();
}

try {
    $db = getDatabaseConnection(); // Assuming you have a function to get the database connection.

    $courseParticipationQuery = "SELECT U.first_name, U.last_name, C.course_name, C.registration_price FROM COURSE_PARTICIPATION AS CP JOIN USERS AS U ON CP.user_id = U.id JOIN COURSES AS C ON CP.course_id = C.id";
    $courseParticipation = $db->query($courseParticipationQuery)->fetchAll(PDO::FETCH_ASSOC);

    $parkingReservationQuery = "SELECT U.first_name, U.last_name, PK.parking_number, PR.start_time, PR.end_time, PR.price FROM PARKING_RESERVATION AS PR JOIN RESERVATIONS AS R ON PR.reservation_id = R.id JOIN USERS AS U ON R.user_id = U.id JOIN PARKINGS AS PK ON PR.parking_id = PK.id";
    $parkingReservation = $db->query($parkingReservationQuery)->fetchAll(PDO::FETCH_ASSOC);

    $planeReservationQuery = "SELECT U.first_name, U.last_name, PL.plane_name, PRes.start_time, PRes.end_time, PRes.price, PRes.type FROM PLANE_RESERVATION AS PRes JOIN RESERVATIONS AS R ON PRes.reservation_id = R.id JOIN USERS AS U ON R.user_id = U.id JOIN PLANES AS PL ON PRes.plane_id = PL.id";
    $planeReservation = $db->query($planeReservationQuery)->fetchAll(PDO::FETCH_ASSOC);

    $serviceReservationQuery = "SELECT U.first_name, U.last_name, S.service_name, S.price FROM SERVICE_RESERVATION AS SR JOIN RESERVATIONS AS R ON SR.reservation_id = R.id JOIN USERS AS U ON R.user_id = U.id JOIN SERVICES AS S ON SR.service_id = S.id";
    $serviceReservation = $db->query($serviceReservationQuery)->fetchAll(PDO::FETCH_ASSOC);

    echo jsonResponse(200, ["X-School" => "ESGI"], [
        "success" => true,
        "infos" => [
            "course_participation" => $courseParticipation,
            "parking_reservation" => $parkingReservation,
            "plane_reservation" => $planeReservation,
            "service_reservation" => $serviceReservation
        ]
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, [], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}
