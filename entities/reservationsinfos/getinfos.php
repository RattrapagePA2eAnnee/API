<?php

require_once __DIR__ . "/../../libraries/body.php";
require_once __DIR__ . "/../../libraries/response.php";
require_once __DIR__ . "/../../libraries/authorization.php";
require_once __DIR__ . "/../../database/connection.php";

if (!authorization(2)) {
    echo jsonResponse(400, [], ["success" => false, "error" => "Vous n'avez pas les droits nécessaires pour effectuer cette action"]);
    exit();
}

try {
    $body = getBody();
    $db = getDatabaseConnection();

    $user_id = $body['reservation_id'];

    $reservationIdsQuery = "SELECT id FROM RESERVATIONS WHERE id = ?";
    $stmt = $db->prepare($reservationIdsQuery);
    $stmt->execute([$user_id]);
    $reservationIds = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

    if (empty($reservationIds)) {
        echo jsonResponse(404, [], ["success" => false, "error" => "Aucune réservation trouvée pour cet utilisateur"]);
        exit();
    }

    $reservationsDetails = [];

    foreach ($reservationIds as $reservationId) {
        // ... (all your SQL queries and data fetch)

    }

    $pdfContent = generateBasicPDF($reservationsDetails);
    $uploadDir = __DIR__ . "/../../facture/";
    $fileName = 'reservation_' . $user_id . '.pdf';
    $filePath = $uploadDir . $fileName;
    
    if (file_put_contents($filePath, $pdfContent)) {
        echo jsonResponse(200, ["X-School" => "ESGI"], [
            "success" => true,
            "file_path" => $filePath
        ]);
    } else {
        echo jsonResponse(500, [], ["success" => false, "error" => "Failed to save the file."]);
    }
    
} catch (Exception $exception) {
    echo jsonResponse(500, [], ["success" => false, "error" => $exception->getMessage()]);
}

function generateBasicPDF($reservationsDetails) {
    $content = "Details de la reservation: " . implode(', ', $reservationsDetails); // Just a basic example, you might want to adjust this

    // Échapper les parenthèses et convertir les sauts de ligne en espaces
    $content = str_replace(['(', ')', "\n", "\r"], ['\(', '\)', ' ', ' '], $content);
    $pdf = "%PDF-1.1\n\n";
    $pdf .= "1 0 obj\n";
    $pdf .= "<< /Type /Catalog /Outlines 2 0 R /Pages 3 0 R >>\n";
    $pdf .= "endobj\n\n";
    
    $pdf .= "2 0 obj\n";
    $pdf .= "<< /Type /Outlines /Count 0 >>\n";
    $pdf .= "endobj\n\n";
    
    $pdf .= "3 0 obj\n";
    $pdf .= "<< /Type /Pages /Kids [4 0 R] /Count 1 /MediaBox [0 0 300 144] >>\n";
    $pdf .= "endobj\n\n";
    
    $pdf .= "4 0 obj\n";
    $pdf .= "<< /Type /Page /Parent 3 0 R /Resources << >> /Contents 5 0 R >>\n";
    $pdf .= "endobj\n\n";
    
    $pdf .= "5 0 obj\n";
    $pdf .= "<< /Length " . (strlen($content) + 41) . " >>\n";  // +41 for the additional PDF commands used for text placement.
    $pdf .= "stream\n";
    $pdf .= "BT\n";
    $pdf .= "70 70 Td\n";
    $pdf .= "(" . $content . ") Tj\n";
    $pdf .= "ET\n";
    $pdf .= "endstream\n";
    $pdf .= "endobj\n\n";
    
    $pdf .= "xref\n";
    $pdf .= "0 6\n";
    $pdf .= "0000000000 65535 f\n";
    $pdf .= "0000000009 00000 n\n";
    $pdf .= "0000000074 00000 n\n";
    $pdf .= "0000000120 00000 n\n";
    $pdf .= "0000000179 00000 n\n";
    $pdf .= "0000000364 00000 n\n";
    
    $pdf .= "trailer\n";
    $pdf .= "<< /Size 6 /Root 1 0 R >>\n";
    $pdf .= "startxref\n";
    $pdf .= "492\n";
    $pdf .= "%%EOF";

    return $pdf;
}

?>
