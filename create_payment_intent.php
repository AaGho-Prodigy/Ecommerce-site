<?php //String Config
require_once 'vendor/autoload.php'; 

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

\Stripe\Stripe::setApiKey('Secret Key'); // Secret Key

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