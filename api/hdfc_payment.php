<?php
// API endpoint: /api/hdfc_payment.php
// Accepts POST: name, email, phone, amount, service, description (optional)
// Returns JSON: { success, payment_link, order_id, error }

require_once __DIR__ . '/../includes/hdfc_smart_gateway.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed']);
    exit;
}

// Required user inputs
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$amount = floatval($_POST['amount'] ?? 0);
// $service = trim($_POST['service'] ?? '');
$description = trim($_POST['description'] ?? "Payment For Order");

if (!$name || !$email || !$phone || !$amount ) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required fields']);
    exit;
}

// Prepare order data
$orderData = [
    'amount' => $amount,
    'customer_id' => 'API_' . md5($email . $phone),
    'email' => $email,
    'phone' => $phone,
    'name' => $name,
    'description' => $description,
];

$hdfc = new HDFCSmartGateway();
$result = $hdfc->createOrder($orderData);

if ($result['success'] && !empty($result['payment_link'])) {
    // If Accept header prefers HTML or not an AJAX request, redirect
    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    if (stripos($accept, 'text/html') !== false && !$isAjax) {
        header('Location: ' . $result['payment_link']);
        exit;
    }
    // Otherwise, return JSON
    echo json_encode([
        'success' => true,
        'payment_link' => $result['payment_link'],
        'order_id' => $result['order_id']
    ]);
    exit;
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $result['error'] ?? 'Could not create HDFC order',
        'response' => $result['response'] ?? null
    ]);
    exit;
}
