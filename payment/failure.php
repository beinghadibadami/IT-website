<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
require_once '../includes/config.php';

$errorMsg = 'Unfortunately, your transaction could not be completed.';

if (isset($_POST['status'])) {
    $status = $_POST['status'] ?? '';
    $txnid = $_POST['txnid'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $service = $_POST['productinfo'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $email = $_POST['email'] ?? '';
    $hash = $_POST['hash'] ?? '';
    $additionalCharges = $_POST['additionalCharges'] ?? '';
    
    $isValid = verifyPayUHash(PAYU_MERCHANT_KEY, $txnid, $amount, $service, $firstname, $email, $status, PAYU_SALT, $hash, $additionalCharges);
    
    if (!$isValid) {
        $errorMsg = 'Invalid payment response. Please contact support.';
    } elseif ($status === 'failure') {
        $errorMsg = 'Payment failed. Please try again or contact support.';
    } elseif ($status === 'cancel') {
        $errorMsg = 'Payment was cancelled. You can try again when ready.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - DivineSyncServe</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="payment-result-page">
        <div class="result-container failure">
            <div class="result-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <h1>Payment Failed</h1>
            <p><?php echo htmlspecialchars($errorMsg); ?></p>
            
            <p class="result-message">Please try again or contact our support team for assistance.</p>
            
            <div class="result-actions">
                <a href="../index.php?page=services" class="btn btn-primary">Try Again</a>
                <a href="../index.php?page=contact" class="btn btn-secondary">Contact Support</a>
            </div>
        </div>
    </div>
</body>
</html>
