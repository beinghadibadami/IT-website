<?php
// HDFC Smart Gateway callback handler (SDK based)

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../includes/hdfc_config.php';
require_once __DIR__ . '/../includes/hdfc_smart_gateway.php';

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

if ($status === 'CHARGED' || $status === 'SUCCESS') {
    $amount = $orderStatus['amount'] ?? '';
    header('Location: ../payment/success.php?txnid=' . urlencode($orderId) . '&amount=' . urlencode($amount));
    exit;
}

$errorMsg = $orderStatus['error_message'] ?? '';
header('Location: ../payment/failure.php?txnid=' . urlencode($orderId) . '&status=' . urlencode($status) . '&error_message=' . urlencode($errorMsg));
exit;
