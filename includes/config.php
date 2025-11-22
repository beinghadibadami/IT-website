<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/templates_data.php';

// Cart Helper Functions
function getCart()
{
    return $_SESSION['cart'] ?? [];
}

function addToCart($templateId, $quantity = 1)
{
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$templateId])) {
        $_SESSION['cart'][$templateId] += $quantity;
    } else {
        $_SESSION['cart'][$templateId] = $quantity;
    }
}

function removeFromCart($templateId)
{
    if (isset($_SESSION['cart'][$templateId])) {
        unset($_SESSION['cart'][$templateId]);
    }
}

function updateCartQuantity($templateId, $quantity)
{
    if ($quantity <= 0) {
        removeFromCart($templateId);
    } else {
        $_SESSION['cart'][$templateId] = $quantity;
    }
}

function getCartTotal()
{
    $total = 0;
    $cart = getCart();
    foreach ($cart as $id => $qty) {
        $template = getTemplateById($id);
        if ($template) {
            $total += $template['price'] * $qty;
        }
    }
    return $total;
}

function getCartCount()
{
    return array_sum(getCart());
}

function clearCart()
{
    $_SESSION['cart'] = [];
}

define('SERVICES_PRICING', [
    'Web Development' => 2999,
    'Cloud Solutions' => 4999,
    'AI & Machine Learning' => 7999,
    'Cybersecurity' => 3499,
    'Mobile App Development' => 5499,
    'Data Analytics' => 4299,
    'Google Ads' => 500,
    'Meta Ads' => 500
]);

define('PAYU_MERCHANT_KEY', getenv('PAYU_MERCHANT_KEY') ?: 'Bh6BeB');
define('PAYU_SALT', getenv('PAYU_SALT') ?: 'hh5sHwBHqDxvgYDbTwvTxSpf2FLDLJAT');
define('PAYU_MODE', getenv('PAYU_MODE') ?: 'test');

if (PAYU_MODE === 'live') {
    define('PAYU_BASE_URL', 'https://secure.payu.in/_payment');
} else {
    define('PAYU_BASE_URL', 'https://test.payu.in/_payment');
}

function getServicePrice($serviceName)
{
    return SERVICES_PRICING[$serviceName] ?? null;
}

// JWT configuration for authentication
define('JWT_SECRET_KEY', getenv('JWT_SECRET_KEY') ?: 'd166cbe02708a5f96c8e5735dc8c844d118a9fb24278a1066ced2fee84bef3cc');
define('JWT_ISSUER', 'divinesyncserve');
define('JWT_EXPIRY_SECONDS', 7 * 24 * 60 * 60); // 7 days

function generatePayUHash($key, $txnid, $amount, $productinfo, $firstname, $email, $salt)
{
    $hashString = $key . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|||||||||||' . $salt;
    return hash('sha512', $hashString);
}

function verifyPayUHash($key, $txnid, $amount, $productinfo, $firstname, $email, $status, $salt, $receivedHash, $additionalCharges = '')
{
    $additionalCharges = $additionalCharges !== '' ? $additionalCharges : '';
    $hashString = $salt . '|' . $status . '||||||' . $additionalCharges . '|||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
    $calculatedHash = hash('sha512', $hashString);
    return $calculatedHash === $receivedHash;
}
?>