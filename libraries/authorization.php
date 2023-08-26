<?php

function authorization($role) {
    require_once __DIR__ . "/../database/connection.php";
    require_once __DIR__ . "/../entities/tokens/get-tokens.php";
    require_once __DIR__ . "/get-bearer-token.php";

    return true;

    $token = getBearerToken();

    // Vérifier si le token existe
    if (!$token) {
        return null; // ou une valeur par défaut si nécessaire
    }

    // Supprimer le préfixe 'Bearer ' du token si présent
    $token = str_replace('Bearer ', '', $token);

    $tokenData = getToken(["token" => $token]);

    $userId = $tokenData[0]['user_id'];

    // Supposons que l'ID de l'utilisateur soit récupéré et stocké dans une variable appelée $userId

    // Logique pour récupérer le rôle de l'utilisateur à partir de l'ID
    $databaseConnection = getDatabaseConnection();
    $selectRoleQuery = $databaseConnection->prepare("SELECT role FROM USERS WHERE id = :id;");
    $selectRoleQuery->execute([
        "id" => $userId,
    ]);
    $userData = $selectRoleQuery->fetch();

    $roleToTest = isset($userData['role']) ? $userData['role'] : null;



    if($roleToTest !== null){
        $rolenumber = getRoleNumber($roleToTest);
        if($rolenumber >= $role ){
            return true;
        }

    } 
    



    return false;


}

function getRoleNumber($role) {
    $correspondanceTable = [
        'USER' => 0,
        'COOKER' => 1,
        'WORKER' => 2,
        'ADMIN' => 3,
    ];

    // Rechercher le numéro correspondant au rôle dans la table de correspondance
    $roleNumber = isset($correspondanceTable[$role]) ? $correspondanceTable[$role] : null;

    return $roleNumber;
}


