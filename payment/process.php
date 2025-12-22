<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
require_once '../includes/config.php';
require_once '../includes/auth.php';

$service = $_POST['service'] ?? '';
$clientAmount = $_POST['amount'] ?? '';
$paymentGateway = 'hdfc_smart_gateway';

// For cart checkout and other payments, ensure user is logged in
$currentUser = auth_current_user();
if (!$currentUser) {
    $_SESSION['toast_message'] = 'Please login to complete your payment';
    $_SESSION['toast_type'] = 'warning';
    header('Location: ../index.php?page=login');
    exit;
}

$name = $currentUser['full_name'] ?? '';
$email = $currentUser['email'] ?? '';
$phone = $currentUser['phone'] ?? '';

if (empty($service) || empty($name) || empty($email)) {
    header('Location: ../index.php?page=services&error=invalid');
    exit;
}

$serverPrice = getServicePrice($service);
if ($serverPrice === null && $service !== 'Cart Checkout') {
    header('Location: ../index.php?page=services&error=invalid_service');
    exit;
}

if ($service === 'Google Ads' || $service === 'Meta Ads') {
    $dynamicAmount = isset($_POST['customerAmount']) ? floatval($_POST['customerAmount']) : 0;
    if ($dynamicAmount < 500) {
        header('Location: ../index.php?page=services&error=invalid_amount');
        exit;
    }
    $amount = $dynamicAmount;
} elseif ($service === 'Cart Checkout') {
    $cartTotal = getCartTotal();
    if ($cartTotal <= 0) {
        header('Location: ../index.php?page=cart&error=empty_cart');
        exit;
    }
    // Verify the amount matches the cart total (allow small float diff)
    $postedAmount = floatval($_POST['amount']);
    if (abs($postedAmount - $cartTotal) > 1) {
        header('Location: ../index.php?page=cart&error=price_mismatch');
        exit;
    }
    $amount = $cartTotal;

    // Create product info from cart
    $cartItems = getCart();
    $itemNames = [];
    foreach ($cartItems as $id => $qty) {
        $tpl = getTemplateById($id);
        if ($tpl) {
            $itemNames[] = $tpl['name'] . ' (x' . $qty . ')';
        }
    }
    $productinfo = implode(', ', $itemNames);
    // Truncate if too long for PayU
    if (strlen($productinfo) > 100) {
        $productinfo = substr($productinfo, 0, 97) . '...';
    }
} else {
    $amount = $serverPrice;
}

$txnid = 'TXN' . time() . rand(1000, 9999);
if ($service !== 'Cart Checkout') {
    $productinfo = $service;
}
$firstname = $name;
$emailAddress = $email;

$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$surl = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/payment/success.php';
$furl = $protocol . '://' . $_SERVER['HTTP_HOST'] . '/payment/failure.php';

$hash = generatePayUHash(PAYU_MERCHANT_KEY, $txnid, $amount, $productinfo, $firstname, $emailAddress, PAYU_SALT);

if ($paymentGateway === 'payu') {
    // --- PayU flow (existing) ---
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment Gateway - DivineSyncServe</title>
        <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo filemtime('../assets/css/style.css'); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="payment-page">
            <div class="payment-container">
                <div class="payment-header">
                    <h1>PayU Payment Gateway</h1>
                    <p>Secure Payment Processing</p>
                </div>

                <div class="payment-info">
                    <h2>Payment Details</h2>
                    <div class="payment-row">
                        <span>Transaction ID:</span>
                        <strong><?php echo htmlspecialchars($txnid); ?></strong>
                    </div>
                    <div class="payment-row">
                        <span>Service:</span>
                        <strong><?php echo htmlspecialchars($service); ?></strong>
                    </div>
                    <div class="payment-row">
                        <span>Amount:</span>
                        <strong>₹<?php echo htmlspecialchars($amount); ?></strong>
                    </div>
                    <div class="payment-row">
                        <span>Customer:</span>
                        <strong><?php echo htmlspecialchars($name); ?></strong>
                    </div>
                    <div class="payment-row">
                        <span>Email:</span>
                        <strong><?php echo htmlspecialchars($email); ?></strong>
                    </div>
                </div>

                <!-- <div class="payment-note">
                <h3><i class="fas fa-info-circle"></i> PayU Integration Setup Required</h3>
                <p>To enable live payments, you need to:</p>
                <ol>
                    <li>Sign up for a PayU merchant account at <a href="https://payu.in" target="_blank">payu.in</a>
                    </li>
                    <li>Get your Merchant Key and Salt from PayU dashboard</li>
                    <li>Add these credentials to your configuration</li>
                    <li>Update the payment form action to PayU's payment URL</li>
                </ol>
                <p><strong>Note:</strong> This is a demo page. In production, the form will automatically submit to
                    PayU's secure payment gateway.</p>
            </div> -->

                <form id="payuForm" action="<?php echo PAYU_BASE_URL; ?>" method="POST">
                    <input type="hidden" name="key" value="<?php echo PAYU_MERCHANT_KEY; ?>">
                    <input type="hidden" name="txnid" value="<?php echo $txnid; ?>">
                    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                    <input type="hidden" name="productinfo" value="<?php echo htmlspecialchars($productinfo); ?>">
                    <input type="hidden" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($emailAddress); ?>">
                    <input type="hidden" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                    <input type="hidden" name="surl" value="<?php echo $surl; ?>">
                    <input type="hidden" name="furl" value="<?php echo $furl; ?>">
                    <input type="hidden" name="hash" value="<?php echo $hash; ?>">

                    <div class="payment-actions">
                        <a href="../index.php?page=services" class="btn btn-secondary">Go Back</a>
                        <?php if (PAYU_MERCHANT_KEY === 'YOUR_MERCHANT_KEY'): ?>
                            <button type="button" onclick="simulatePayment()" class="btn btn-primary">Simulate Payment
                                (Demo)</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </body>

    </html>
    <?php
    // End PayU branch
}
// HDFC branch handled below
elseif ($paymentGateway === 'hdfc_smart_gateway') {

    require_once __DIR__ . '/../includes/hdfc_smart_gateway.php';
    require_once __DIR__ . '/../includes/mongo.php';

    $hdfc = new HDFCSmartGateway();

    $orderData = [
        'amount' => $amount,
        'customer_id' => $currentUser['id'] ?? ('CUST_' . time()),
        'email' => $email,
        'phone' => $phone,
        'name' => $name,
        'description' => $productinfo,
    ];

    $result = $hdfc->createOrder($orderData);

    if ($result['success'] && !empty($result['payment_link'])) {

        insert_transaction($transactions, [
            'user_id' => $currentUser['id'] ?? null,
            'gateway' => 'hdfc_smart_gateway',
            'order_id' => $result['order_id'],
            'amount' => $amount,
            'currency' => 'INR',
            'status' => 'INITIATED',
            'customer' => [
                'name' => $name,
                'email' => $email,
                'phone' => $phone
            ],
            'gateway_response' => $result['response']
        ]);

        header('Location: ' . $result['payment_link']);
        exit;
    }

    error_log('HDFC order creation failed: ' . json_encode($result));
    $errorMsg = $result['error'] ?? 'Unable to initiate payment';
    header('Location: ../payment/failure.php?status=init_failed&error_message=' . urlencode($errorMsg));
    exit;
}
