<?php
// HDFC Smart Gateway callback handler (SDK based)

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/hdfc_config.php';
require_once __DIR__ . '/../includes/hdfc_smart_gateway.php';
require_once __DIR__ . '/../includes/mongo.php';

session_start();

$callbackData = array_merge($_GET, $_POST);
$orderId = $callbackData['order_id'] ?? $callbackData['orderId'] ?? null;

if (!$orderId) {
    error_log("HDFC Callback: Missing order_id");
    $_SESSION['error'] = 'Invalid payment response.';
    header('Location: ../payment/failure.php');
    exit;
}

$hdfc = new HDFCSmartGateway();
$orderStatus = $hdfc->getOrderStatus($orderId);

if (!$orderStatus || isset($orderStatus['error_message'])) {
    error_log("HDFC Callback status fetch failed: " . json_encode($orderStatus));
    $_SESSION['error'] = 'Unable to verify payment status.';
    header('Location: ../payment/failure.php');
    exit;
}

$status = $orderStatus['status'] ?? null;

// Update transaction in MongoDB
$gatewayStatus = $status;
$finalStatus = ($status === 'CHARGED' || $status === 'SUCCESS') ? 'Success' : 'Failed';

// Filter gateway response to store only required fields
$filteredResponse = [
    'customerEmail' => $orderStatus['customerEmail'] ?? null,
    'customer_phone' => $orderStatus['customerPhone'] ?? null,
    'status' => $orderStatus['status'] ?? null,
    'merchant_id' => $orderStatus['merchantId'] ?? null,
    'payment_links' => $orderStatus['paymentLinks'] ?? null,
    'order_id' => $orderStatus['orderId'] ?? null,
    // Attempt to capture payment method details if available
    'payment_method' => $orderStatus['paymentMethod'] ?? null,
    'payment_method_type' => $orderStatus['paymentMethodType'] ?? null,
    'txn_id' => $orderStatus['txnId'] ?? $orderStatus['id'] ?? null,
    'amountRefunded' => $orderStatus['amountRefunded'] ?? null,
    'effectiveAmount' => $orderStatus['effectiveAmount'] ?? null,
    'dateCreated' => $orderStatus['dateCreated'] ?? null,
    'lastUpdated' => $orderStatus['lastUpdated'] ?? null,

];

update_transaction($transactions, $orderId, [
    'status' => $finalStatus,
    'gateway_status' => $gatewayStatus,
    'gateway_response' => $filteredResponse
]);

if ($status === 'CHARGED' || $status === 'SUCCESS') {
    $amount = $orderStatus['amount'] ?? '';
    header('Location: ../payment/success.php?txnid=' . urlencode($orderId) . '&amount=' . urlencode($amount));
    exit;
}

$errorMsg = $orderStatus['error_message'] ?? '';
header('Location: ../payment/failure.php?txnid=' . urlencode($orderId) . '&status=' . urlencode($status) . '&error_message=' . urlencode($errorMsg));
exit;
