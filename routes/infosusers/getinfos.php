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
    $body = getBody();
    $db = getDatabaseConnection();

    $user_id = $body['user_id'];

    $reservationIdsQuery = "SELECT id FROM RESERVATIONS WHERE user_id = ?";
    $stmt = $db->prepare($reservationIdsQuery);
    $stmt->execute([$user_id]);
    $reservationIds = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    if (empty($reservationIds)) {
        echo jsonResponse(404, [], ["success" => false, "error" => "Aucune réservation trouvée pour cet utilisateur"]);
        exit();
    }

    $reservationsDetails = [];

    foreach ($reservationIds as $reservationId) {
        $parkingReservationQuery = "SELECT U.first_name, U.last_name, PK.parking_number, PR.start_time, PR.end_time, PR.price FROM PARKING_RESERVATION AS PR JOIN USERS AS U ON PR.id = U.id JOIN PARKINGS AS PK ON PR.id = PK.id WHERE PR.id = ?";
        $planeReservationQuery = "SELECT U.first_name, U.last_name, PL.plane_name, PRes.start_time, PRes.end_time, PRes.price, PRes.type FROM PLANE_RESERVATION AS PRes JOIN USERS AS U ON PRes.id = U.id JOIN PLANES AS PL ON PRes.id = PL.id WHERE PRes.id = ?";
        $serviceReservationQuery = "SELECT U.first_name, U.last_name, S.service_name, S.price FROM SERVICE_RESERVATION AS SR JOIN USERS AS U ON SR.id = U.id JOIN SERVICES AS S ON SR.id = S.id WHERE SR.reservation_id = ?";

        $parkingReservation = $db->prepare($parkingReservationQuery);
        $parkingReservation->execute([$reservationId]);
        $parkingReservationResult = $parkingReservation->fetchAll(PDO::FETCH_ASSOC);

        $planeReservation = $db->prepare($planeReservationQuery);
        $planeReservation->execute([$reservationId]);
        $planeReservationResult = $planeReservation->fetchAll(PDO::FETCH_ASSOC);

        $serviceReservation = $db->prepare($serviceReservationQuery);
        $serviceReservation->execute([$reservationId]);
        $serviceReservationResult = $serviceReservation->fetchAll(PDO::FETCH_ASSOC);

        $reservationsDetails[$reservationId] = [
            "parking_reservation" => $parkingReservationResult,
            "plane_reservation" => $planeReservationResult,
            "service_reservations" => $serviceReservationResult
        ];
    }

    echo jsonResponse(200, ["X-School" => "ESGI"], [
        "success" => true,
        "reservations" => $reservationsDetails
    ]);
} catch (Exception $exception) {
    echo jsonResponse(500, [], [
        "success" => false,
        "error" => $exception->getMessage()
    ]);
}

?>
