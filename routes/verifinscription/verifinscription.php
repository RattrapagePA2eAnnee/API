<!DOCTYPE html>
<html>
<head>
    <title>Validation E-mail</title>
    <style>
        @keyframes blink {
            0% { opacity: 0; }
            50% { opacity: 1; }
            100% { opacity: 0; }
        }

        h1::after {
            content: '...';
            animation: blink 1s infinite;
        }
    </style>
     <meta http-equiv="refresh" content="3;url=https://aen.best"> 
</head>
<body>
    <h1>Validation de votre email en cours </h1>
    <p>Vous serez redirigé(e) dans un instant vers la page de connexion.</p>
    
    <?php
    require_once __DIR__ . "/../../entities/tokens/get-tokens.php";
    require_once __DIR__ . "/../../entities/tokens/delete-token.php";
    require_once __DIR__ . "/../../entities/users/update-user.php";



    // Récupérer le token depuis l'URL
    $token = $_GET['token'] ?? '';
   

    if($token !==""){
        $token = getToken(["token" => $token])?? '';
        if($token){
            $tokenId = $token[0]["id"];
            $id= $token[0]["user_id"];
            $status= updateUser((string)$id,["subscription_status" => "ACTIVE"]);
            if($status){
                deleteToken((string)$tokenId);
            }
        }
    }



    ?>
    
</body>
</html>
