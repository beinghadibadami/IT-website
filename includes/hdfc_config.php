<?php
// HDFC Smart Gateway configuration
// DO NOT expose these values in frontend or public code

define('HDFC_MERCHANT_ID', getenv('HDFC_MERCHANT_ID') ?: '');
define('HDFC_CLIENT_ID', getenv('HDFC_CLIENT_ID') ?: '');
define('HDFC_API_KEY', getenv('HDFC_API_KEY') ?: '821F33ADD6B49889190C4012129002');
define('HDFC_API_SECRET', getenv('HDFC_API_SECRET') ?: '');
define('HDFC_ENVIRONMENT', getenv('HDFC_ENVIRONMENT') ?: 'sandbox');

define('HDFC_RESPONSE_KEY', getenv('HDFC_RESPONSE_KEY') ?: '10A39E24C274E70AE23A3255303184');

define('HDFC_SANDBOX_BASE_URL', 'https://smartgatewayuat.hdfcbank.com');
define('HDFC_PRODUCTION_BASE_URL', 'https://smartgateway.hdfcbank.com');
define('HDFC_CURRENCY', 'INR');
define('HDFC_COUNTRY', 'IN');

// Return/Callback URL for payment status update
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
define('HDFC_RETURN_URL', $protocol . '://' . $_SERVER['HTTP_HOST'] . '/payment/hdfc_callback.php');

