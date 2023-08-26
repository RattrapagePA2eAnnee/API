<?php


ini_set("display_errors", 1);
error_reporting(E_ALL);



require_once __DIR__ . "/libraries/path.php";
require_once __DIR__ . "/libraries/method.php";
require_once __DIR__ . "/libraries/response.php";

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

if (isPath("users")) {

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/users/post.php";
        die();
    }
}

if (isPath("getusers")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/users/get.php";
        die();
    }
}

if (isPath("users/:user")) {
    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/users/delete.php";
        die();
    }

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/users/patch.php";
        die();
    }
}

if (isPath("courses")) {

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/courses/post.php";
        die();
    }
}

if (isPath("getcourses")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/courses/get.php";
        die();
    }
}

if (isPath("courses/:course")) {
    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/courses/delete.php";
        die();
    }

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/courses/patch.php";
        die();
    }
}


if (isPath("parkings")) {

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/parkings/post.php";
        die();
    }
}

if (isPath("getparkings")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/parkings/get.php";
        die();
    }
}

if (isPath("parkings/:parking")) {
    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/parkings/delete.php";
        die();
    }

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/parkings/patch.php";
        die();
    }
}


if (isPath("planes")) {

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/planes/post.php";
        die();
    }
}

if (isPath("getplanes")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/planes/get.php";
        die();
    }
}

if (isPath("planes/:plane")) {
    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/planes/delete.php";
        die();
    }

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/planes/patch.php";
        die();
    }
}


if (isPath("services")) {

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/services/post.php";
        die();
    }
}

if (isPath("getservices")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/services/get.php";
        die();
    }
}

if (isPath("services/:service")) {
    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/services/delete.php";
        die();
    }

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/services/patch.php";
        die();
    }
}


if (isPath("courseparticipations")) {

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/courseparticipation/post.php";
        die();
    }
}

if (isPath("getcourseparticipations")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/courseparticipation/get.php";
        die();
    }
}

if (isPath("coursesparticipations/:courseparticipation")) {

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/courseparticipation/patch.php";
        die();
    }
}



if (isPath("parkingreservations")) {

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/parkingreservation/post.php";
        die();
    }
}

if (isPath("getparkingreservations")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/parkingreservation/get.php";
        die();
    }
}

if (isPath("parkingreservations/:parkingreservation")) {

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/parkingreservation/patch.php";
        die();
    }
}

if (isPath("planereservations")) {

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/planereservation/post.php";
        die();
    }
}

if (isPath("getplanereservations")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/planereservation/get.php";
        die();
    }
}

if (isPath("planereservations/:reservation")) {
    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/planereservation/patch.php";
        die();
    }
}

if (isPath("servicereservations")) {

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/servicereservation/post.php";
        die();
    }
}

if (isPath("getservicereservations")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/servicereservation/get.php";
        die();
    }
}

if (isPath("servicereservations/:servicereservation")) {

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/servicereservation/patch.php";
        die();
    }
}


if(isPath("connection")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/connection/post.php";
        die();
    }

}

if (isPath("tokens")) {

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/tokens/post.php";
        die();
    }
}

if (isPath("gettokens")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/tokens/get.php";
        die();
    }
}

if (isPath("tokens/:token")) {
    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/tokens/delete.php";
        die();
    }
}

if(isPath("connectiontoken")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/connectiontoken/get.php";
        die();
    }

}


if(isPath("register")) {
    if(isPostMethod()) {
        require_once __DIR__ . "/routes/register/post.php";
        die();
    }
}


if (isPath("stripeapi")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/stripe_api.php"; 
        die();
    }
}

if (isPath("instructordisponibility")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/instructordisponibility/post.php";
        die();
    }
}

if (isPath("planedisponibility")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/planedisponibility/post.php";
        die();
    }
}

if (isPath("planedisponibility")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/planedisponibility/post.php";
        die();
    }
}

if (isPath("parkingdisponibility")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/parkingdisponibilitys/post.php";
        die();
    }
}

if (isPath("infos")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/infos/getinfos.php";
        die();
    }
}

if (isPath("planesreservations")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/planesreservations/post.php";
        die();
    }
}

if (isPath("getreservations")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/reservations/get.php";
        die();
    }
}


if (isPath("reservations")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/reservations/post.php";
        die();
    }
}

if (isPath("reservations/:reservation")) {

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/reservations/patch.php";
        die();
    }
}


if (isPath("pdf")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/pdf/post.php";
        die();
    }
}

if (isPath("lessons")) {

    if (isPostMethod()) {
        require_once __DIR__ . "/routes/lessons/post.php";
        die();
    }
}

if (isPath("getlessons")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/lessons/get.php";
        die();
    }
}

if (isPath("lessons/:lesson")) {
    if (isDeleteMethod()) {
        require_once __DIR__ . "/routes/lessons/delete.php";
        die();
    }

    if (isPatchMethod()) {
        require_once __DIR__ . "/routes/users/patch.php";
        die();
    }
}

if (isPath("infosusers")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/routes/infosusers/getinfos.php";
        die();
    }
}

if (isPath("reservationsinfos")) {
    if (isPostMethod()) {
        require_once __DIR__ . "/entities/reservationsinfos/getinfos.php";
        die();
    }
}

$chaineRecherche = "validemail";

if (strpos($_SERVER['REQUEST_URI'], $chaineRecherche) !== false) {
    require_once __DIR__ . "/routes/verifinscription/verifinscription.php";
    die();
}








echo jsonResponse(404, [], [
    "success" => false,
    "message" => "Route not found"
]);

