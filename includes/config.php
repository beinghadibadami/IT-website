<?php
define('SERVICES_PRICING', [
    'Web Development' => 2999,
    'Cloud Solutions' => 4999,
    'AI & Machine Learning' => 7999,
    'Cybersecurity' => 3499,
    'Mobile App Development' => 5499,
    'Data Analytics' => 4299,
    'Google Ads'=>500,
    'Meta Ads'=>500
]);

define('PAYU_MERCHANT_KEY', getenv('PAYU_MERCHANT_KEY') ?: 'Bh6BeB');
define('PAYU_SALT', getenv('PAYU_SALT') ?: 'hh5sHwBHqDxvgYDbTwvTxSpf2FLDLJAT');
define('PAYU_MODE', getenv('PAYU_MODE') ?: 'test');

if (PAYU_MODE === 'live') {
    define('PAYU_BASE_URL', 'https://secure.payu.in/_payment');
} else {
    define('PAYU_BASE_URL', 'https://test.payu.in/_payment');
}

function getServicePrice($serviceName) {
    return SERVICES_PRICING[$serviceName] ?? null;
}

function generatePayUHash($key, $txnid, $amount, $productinfo, $firstname, $email, $salt) {
    $hashString = $key . '|' . $txnid . '|' . $amount . '|' . $productinfo . '|' . $firstname . '|' . $email . '|||||||||||' . $salt;
    return hash('sha512', $hashString);
}

function verifyPayUHash($key, $txnid, $amount, $productinfo, $firstname, $email, $status, $salt, $receivedHash, $additionalCharges = '') {
    $additionalCharges = $additionalCharges !== '' ? $additionalCharges : '';
    $hashString = $salt . '|' . $status . '||||||' . $additionalCharges . '|||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
    $calculatedHash = hash('sha512', $hashString);
    return $calculatedHash === $receivedHash;
}
?>
