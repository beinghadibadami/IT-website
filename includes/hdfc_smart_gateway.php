<?php
// HDFC Smart Gateway Handler (Using Official Juspay PHP SDK v2)
// Documentation: https://developer.juspay.in/docs/express-checkout-php-sdk-integration

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/hdfc_config.php';

use Juspay\JuspayEnvironment;
use Juspay\Model\Order;

class HDFCSmartGateway
{
    private $environment;
    private $currency;
    private $returnUrl;

    public function __construct()
    {
        // Determine environment (sandbox/production)
        $this->environment = HDFC_ENVIRONMENT;
        $this->currency = HDFC_CURRENCY;
        $this->returnUrl = HDFC_RETURN_URL;

        // Initialize Juspay SDK
        try {
            JuspayEnvironment::init()
                ->withMerchantId(HDFC_MERCHANT_ID)
                ->withBaseUrl(HDFC_BASE_URL)
                ->withApiKey(HDFC_API_KEY);

            error_log("Juspay SDK Initialized for " . $this->environment . " with Merchant ID: " . HDFC_MERCHANT_ID);

        } catch (Exception $e) {
            error_log("CRITICAL: Juspay SDK Init Error: " . $e->getMessage() . " in " . $e->getFile() . " on line " . $e->getLine());
        }
    }

    /**
     * Create order and return hosted payment page URL
     */
    public function createOrder(array $orderData)
    {
        $orderId = 'ORD_' . time() . '_' . random_int(1000, 9999);

        try {
            $params = [
                "order_id" => $orderId,
                "amount" => (float) $orderData['amount'],
                "currency" => $this->currency,
                "customer_id" => $orderData['customer_id'] ?? ('CUST_' . time()),
                "customer_email" => $orderData['email'],
                "customer_phone" => $orderData['phone'],
                "payment_page_client_id" => HDFC_CLIENT_ID,
                "action" => "paymentPage",
                "return_url" => $this->returnUrl,
                "description" => $orderData['description'] ?? 'Payment',
                "first_name" => $orderData['name'] ?? ''
            ];

            $order = Order::create($params);

            // Extract accessible properties from JuspayResponse (SDK uses static storage)
            $response = $order->{'*'};
            error_log("HDFC CreateOrder Raw Response: " . print_r($response, true));

            if (!empty($response['paymentLinks']['web'])) {
                return [
                    'success' => true,
                    'order_id' => $orderId,
                    'payment_link' => $response['paymentLinks']['web'],
                    'response' => $response
                ];
            }

            return [
                'success' => false,
                'error' => 'Payment link not generated',
                'response' => $response
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Server-to-server order status check
     */
    public function getOrderStatus(string $orderId)
    {
        try {
            $order = Order::status(['order_id' => $orderId]);
            $response = $order->{'*'};
            error_log("HDFC GetOrderStatus Raw Response: " . print_r($response, true));
            return $response;
        } catch (Exception $e) {
            return [
                'success' => false,
                'error_message' => $e->getMessage()
            ];
        }
    }
}
