<?php
require_once 'vendor/autoload.php'; 

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

\Stripe\Stripe::setApiKey('sk_test_51RbksnPap1ekO0WTi3X3KDzDqcEbjVh795g6mcck8b2fijAmDx1UTgPT7Yt5rmEtAGyWO7HSZzW7x1hawaLVnuu800od0OS4L9'); // Replace with your key

try {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (!isset($data['amount']) || !isset($data['currency'])) {
        throw new Exception("Missing required fields.");
    }

    $paymentIntent = \Stripe\PaymentIntent::create([
        'amount' => $data['amount'], 
        'currency' => $data['currency'], 
        'metadata' => [
            'customer_email' => $data['billingDetails']['email'] ?? '',
        ],
    ]);

    echo json_encode(['clientSecret' => $paymentIntent->client_secret]);

} catch (Exception $e) {
    error_log("Stripe Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>