<?php
// HDFC Smart Gateway configuration
// DO NOT expose these values in frontend or public code

// Environment: 'sandbox' or 'production'
define('HDFC_ENVIRONMENT', getenv('HDFC_ENVIRONMENT') ?: 'sandbox');

if (HDFC_ENVIRONMENT === 'production') {
    // PRODUCTION CREDENTIALS (Get these from your HDFC/Juspay Production Dashboard)
    define('HDFC_MERCHANT_ID', getenv('HDFC_PROD_MERCHANT_ID') ?: 'YOUR_PRODUCTION_MERCHANT_ID');
    define('HDFC_CLIENT_ID', getenv('HDFC_PROD_CLIENT_ID') ?: 'YOUR_PRODUCTION_CLIENT_ID');
    define('HDFC_API_KEY', getenv('HDFC_PROD_API_KEY') ?: 'YOUR_PRODUCTION_API_KEY');
    define('HDFC_BASE_URL', 'https://smartgateway.hdfc.hdfcbank.com/');
} else {
    // SANDBOX CREDENTIALS (Default / Test values)
    define('HDFC_MERCHANT_ID', getenv('HDFC_SANDBOX_MERCHANT_ID') ?: 'SG4091');
    define('HDFC_CLIENT_ID', getenv('HDFC_SANDBOX_CLIENT_ID') ?: 'hdfcmaster');
    define('HDFC_API_KEY', getenv('HDFC_SANDBOX_API_KEY') ?: '821F33ADD6B49889190C4012129002');
    define('HDFC_BASE_URL', 'https://smartgatewayuat.hdfcbank.com');
}

// Common Configuration
define('HDFC_CURRENCY', 'INR');
define('HDFC_COUNTRY', 'IN');

// Return/Callback URL for payment status update
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
define('HDFC_RETURN_URL', $protocol . '://' . $host . '/payment/hdfc_callback.php');

