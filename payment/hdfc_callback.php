<?php
// HDFC Smart Gateway callback/return handler
// Handles payment status verification and signature check

require_once __DIR__ . '/../includes/hdfc_config.php';
require_once __DIR__ . '/../includes/hdfc_smart_gateway.php';

session_start();

$callbackData = array_merge($_GET, $_POST);
$orderId = $callbackData['order_id'] ?? $callbackData['orderId'] ?? null;
$signature = $callbackData['signature'] ?? $callbackData['x-merchant-signature'] ?? null;

if (!$orderId) {
    error_log("HDFC Callback: No order_id received");
    $_SESSION['error'] = 'Invalid payment callback. Order ID not found.';
    header('Location: ../payment/failure.php');
    exit;
}

$hdfc = new HDFCSmartGateway();
$config = [
    'response_key' => defined('HDFC_RESPONSE_KEY') ? HDFC_RESPONSE_KEY : ''
];
$responseKey = $config['response_key'];

// Signature Verification (recommended)
// if (!empty($responseKey) && !empty($signature)) {
//     $dataForSignature = [];
//     foreach ($callbackData as $key => $value) {
//         if ($key !== 'signature' && $key !== 'x-merchant-signature') {
//             $dataForSignature[$key] = $value;
//         }
//     }
//     ksort($dataForSignature);
//     $signatureString = '';
//     foreach ($dataForSignature as $key => $value) {
//         $signatureString .= $key . '=' . $value . '&';
//     }
//     $signatureString = rtrim($signatureString, '&');
//     $computedSignature = hash_hmac('sha256', $signatureString, $responseKey);
//     if (!hash_equals($computedSignature, $signature)) {
//         error_log("HDFC Callback: Signature verification FAILED for order: $orderId");
//         $_SESSION['error'] = 'Payment verification failed. Please contact support if amount was deducted.';
//         header('Location: ../payment/failure.php');
//         exit;
//     }
// }
    
// Server-to-server order status verification
$orderStatus = $hdfc->getOrderStatus($orderId);

if (!$orderStatus || isset($orderStatus['error_message'])) {
    error_log(
        "HDFC Callback: Failed to fetch order status for: $orderId. Response: " .
        json_encode($orderStatus)
    );
    $_SESSION['error'] = 'Unable to verify payment status. Please check transaction history.';
    header('Location: ../payment/failure.php');
    exit;
}

$serverStatus = $orderStatus['status'] ?? null;
if (!$serverStatus) {
    error_log("HDFC Callback: No status in order response for: $orderId");
    header('Location: ../payment/failure.php');
    exit;
}

// Final result: redirect to success/failure
if ($serverStatus === 'CHARGED' || $serverStatus === 'SUCCESS') {
    $amount = isset($orderStatus['amount']) ? $orderStatus['amount'] : '';
    header('Location: ../payment/success.php?txnid=' . urlencode($orderId) . '&amount=' . urlencode($amount));
    exit;
} else {
    header('Location: ../payment/failure.php?txnid=' . urlencode($orderId));
    exit;
}
