<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
require_once '../includes/config.php';

$errorMsg = 'Unfortunately, your transaction could not be completed.';

if (isset($_POST['status']) || isset($_GET['status'])) {
    $status = $_REQUEST['status'] ?? 'failure';
    $txnid = $_REQUEST['txnid'] ?? '';
    // PayU specific
    if (isset($_POST['hash'])) {
        $amount = $_POST['amount'] ?? '';
        $service = $_POST['productinfo'] ?? '';
        $firstname = $_POST['firstname'] ?? '';
        $email = $_POST['email'] ?? '';
        $hash = $_POST['hash'] ?? '';
        $additionalCharges = $_POST['additionalCharges'] ?? '';

        $isValid = verifyPayUHash(PAYU_MERCHANT_KEY, $txnid, $amount, $service, $firstname, $email, $status, PAYU_SALT, $hash, $additionalCharges);
        if (!$isValid) {
            $errorMsg = 'Invalid payment response. Security verification failed.';
        }
    }

    // Custom Error Message from URL
    if (isset($_GET['error_message'])) {
        $errorMsg = htmlspecialchars($_GET['error_message']);
    }
    // Status based messages
    elseif ($status === 'failure') {
        $errorMsg = 'Payment failed. Please try again.';
    } elseif ($status === 'cancel') {
        $errorMsg = 'Payment was cancelled by user.';
    } elseif ($status === 'declined') {
        $errorMsg = 'Payment was declined by the bank.';
    } elseif ($status !== 'failure') {
        $errorMsg = 'Payment Status: ' . htmlspecialchars(ucfirst($status));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed - DivineSyncServe</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo filemtime('../assets/css/style.css'); ?>">
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