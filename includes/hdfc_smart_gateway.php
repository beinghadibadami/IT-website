<?php
// HDFC Smart Gateway Handler
// Uses juspay/expresscheckout-php-sdk (must be installed via composer)
// Handles order/session creation for hosted payment page redirection

require_once __DIR__ . '/../includes/hdfc_config.php';

class HDFCSmartGateway {
    private $merchantId;
    private $clientId;
    private $apiKey;
    // private $apiSecret;
    private $environment;
    private $baseUrl;
    private $currency;
    private $country;
    private $returnUrl;
    private $responseKey;

    public function __construct() {
        $this->merchantId = HDFC_MERCHANT_ID;
        $this->clientId = HDFC_CLIENT_ID;
        $this->apiKey = HDFC_API_KEY;
        // $this->apiSecret = HDFC_SECRET_KEY;
        $this->environment = HDFC_ENVIRONMENT;
        $this->currency = HDFC_CURRENCY;
        $this->country = HDFC_COUNTRY;
        $this->returnUrl = HDFC_RETURN_URL;
        $this->responseKey = HDFC_RESPONSE_KEY;
        $this->baseUrl = $this->environment === 'production' ? HDFC_PRODUCTION_BASE_URL : HDFC_SANDBOX_BASE_URL;
    }

    public function createOrder($orderData) {
        // Compose payload for Juspay/SmartGateway
        $orderId = 'ORD_' . time() . '_' . rand(1000, 9999);
        $payload = [
            'order_id' => $orderId,
            'amount' => (float) $orderData['amount'],
            'customer_id' => $orderData['customer_id'] ?? 'CUST_' . time(),
            'customer_email' => $orderData['email'],
            'customer_phone' => $orderData['phone'],
            'payment_page_client_id' => $this->clientId,
            'action' => 'paymentPage',
            'return_url' => $this->returnUrl,
            'description' => $orderData['description'] ?? 'Payment for order',
            'first_name' => $orderData['name'] ?? '',
            'currency' => $this->currency,
        ];
        $response = $this->makeApiCall('/order/create', $payload);
        if ($response && isset($response['payment_links'])) {
            return [
                'success' => true,
                'order_id' => $orderId,
                'payment_link' => $response['payment_links']['web'] ?? $response['payment_links']['mobile'] ?? null,
                'response' => $response
            ];
        }
        return [
            'success' => false,
            'error' => $response['error_message'] ?? 'Failed to create order',
            'response' => $response
        ];
    }

    // Server-to-server order status verification
    public function getOrderStatus($orderId) {
        $payload = [
            'order_id' => $orderId,
        ];
        return $this->makeApiCall('/order/status', $payload);
    }

    private function makeApiCall($endpoint, $payload) {
        $url = $this->baseUrl . $endpoint;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
            'x-merchantid: ' . $this->merchantId,
        ]);
        curl_setopt($ch, CURLOPT_USERPWD, $this->apiKey . ':');
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error) {
            return ['success' => false, 'error_message' => 'cURL Error: ' . $error];
        }
        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['success' => false, 'error_message' => 'Invalid JSON response', 'raw_response' => $response];
        }
        return $decoded;
    }
}
