<?php

require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../entities/recipes/create-recipe.php";
require_once __DIR__ . "/../../libraries/authorization.php";

if (authorization(0)) {
    // Vérifie si une image a été envoyée
    if (isset($_FILES['photo'])) {
        // Vérifie si le dossier de destination existe, sinon le crée
        $uploadDir = __DIR__ . "/../../img/"; // Ajouter un slash avant "pictures"

        // Génère un nom de fichier unique pour éviter les doublons
        $fileName = uniqid() . '_' . $_FILES['photo']['name'];
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
            // L'image a été téléchargée avec succès
            $response = [
                'status' => 'success',
                'message' => 'Photo uploaded successfully.',
                'file_name' => $fileName,
                'file_path' => $filePath
            ];
            http_response_code(200);
        } else {
            // Échec du téléchargement de l'image
            $response = [
                'status' => 'error',
                'message' => 'Failed to upload the photo.'
            ];
            http_response_code(500);
        }
    } else {
        // Aucune image envoyée
        $response = [
            'status' => 'error',
            'message' => 'No photo uploaded.'
        ];
        http_response_code(400);
    }

    echo json_encode($response);
}
