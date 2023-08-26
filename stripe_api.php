<?php
require_once('stripe-php/init.php'); // Inclure le fichier d'initialisation de Stripe

$data = json_decode(file_get_contents("php://input"), true);
$token = $data['token'];
$amount = $data['amount'];

// Configurez votre clé secrète Stripe
\Stripe\Stripe::setApiKey('sk_test_51NOgBaDOtbT2jeqreg2wwm7XIWu8yHJAf4DAjE5wAuVHMGjtUGv8zqCslTizMje4Vuk7N0Q32vJOfRQ8R7CCaDdF00VHEdBY2G');


  try {
    // Créez une intention de paiement avec Stripe
    $paymentIntent = \Stripe\PaymentIntent::create([
      'amount' => $amount,
      'currency' => 'eur', // Remplacez par la devise souhaitée
      'payment_method' => $token,
      'confirmation_method' => 'manual', // Spécifiez la méthode de confirmation manuelle
    ]);
  
    // Récupérez l'ID de l'intention de paiement
    $paymentIntentId = $paymentIntent->id;
  
    // Créez une instance de PaymentIntent avec l'ID
    $paymentIntentInstance = new \Stripe\PaymentIntent($paymentIntentId) ;
  
    // Confirmez l'intention de paiement en appelant la méthode sur l'instance
    $paymentIntentInstance->confirm();
  
    // Envoyez une réponse réussie au client
    http_response_code(200);
  } catch (\Stripe\Exception\CardException $e) {
    // Gérez les erreurs de paiement de la carte
    $error = $e->getError();
    http_response_code(500);
    echo json_encode(['error' => $error->message]);
  } catch (\Stripe\Exception\RateLimitException | \Stripe\Exception\InvalidRequestException | \Stripe\Exception\AuthenticationException | \Stripe\Exception\ApiConnectionException | \Stripe\Exception\ApiErrorException $e) {
    // Gérez les autres erreurs Stripe
    $error = $e->getError();
    http_response_code(500);
    echo json_encode(['error' => $error->message]);
  } catch (Exception $e) {
    // Gérez les erreurs inattendues
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
  }
  