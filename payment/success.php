<?php
header('Cache-Control: no-cache, no-store, must-revalidate');
require_once '../includes/config.php';

$isPayUCallback = isset($_POST['status']);

if ($isPayUCallback) {
    $status = $_POST['status'] ?? '';
    $txnid = $_POST['txnid'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $service = $_POST['productinfo'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $email = $_POST['email'] ?? '';
    $hash = $_POST['hash'] ?? '';
    $additionalCharges = $_POST['additionalCharges'] ?? '';

    $isValid = verifyPayUHash(PAYU_MERCHANT_KEY, $txnid, $amount, $service, $firstname, $email, $status, PAYU_SALT, $hash, $additionalCharges);

    if (!$isValid || $status !== 'success') {
        header('Location: failure.php');
        exit;
    }
} else {
    $txnid = $_GET['txnid'] ?? $_POST['txnid'] ?? 'N/A';
    $service = $_GET['service'] ?? $_POST['productinfo'] ?? 'N/A';
    $amount = $_GET['amount'] ?? $_POST['amount'] ?? 'N/A';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - DivineSyncServe</title>
    <link rel="stylesheet" href="../assets/css/style.css?v=<?php echo filemtime('../assets/css/style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="payment-result-page">
        <div class="result-container success">
            <div class="result-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Payment Successful!</h1>
            <p>Thank you for your purchase. Your transaction has been completed successfully.</p>

            <div class="result-details">
                <div class="detail-row">
                    <span>Transaction ID:</span>
                    <strong><?php echo htmlspecialchars($txnid); ?></strong>
                </div>
                <div class="detail-row">
                    <span>Amount Paid:</span>
                    <strong><?php echo htmlspecialchars($amount); ?></strong>
                </div>
            </div>

            <p class="result-message">We'll contact you shortly to begin working on your project.</p>

            <div class="result-actions">
                <a href="../index.php?page=home" class="btn btn-primary">Back to Home</a>
                <a href="../index.php?page=services" class="btn btn-secondary">View Services</a>
            </div>
        </div>
    </div>
</body>

</html>