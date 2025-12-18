<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$title = "Divine SyncServe - Innovative IT Solutions";

require_once __DIR__ . '/includes/mongo.php';
// Handle auth-related actions BEFORE any HTML output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'login') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $errors = [];

    $user = auth_authenticate($email, $password, $errors);
    if ($user && empty($errors)) {
        auth_login_user($user);
        $_SESSION['toast_message'] = 'Logged in successfully';
        $_SESSION['toast_type'] = 'success';
        header('Location: index.php');
        exit;
    }

    $_SESSION['login_errors'] = $errors;
    $_SESSION['login_old'] = ['email' => $email];
    $_SESSION['toast_message'] = $errors['general'] ?? 'Please fix the errors in the login form';
    $_SESSION['toast_type'] = 'warning';
    header('Location: index.php?page=login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'signup') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $errors = [];

    $user = auth_register_user($fullName, $email, $username, $phone, $password, $confirmPassword, $errors);
    if ($user && empty($errors)) {
        auth_login_user($user);
        $_SESSION['toast_message'] = 'Account created successfully';
        $_SESSION['toast_type'] = 'success';
        header('Location: index.php');
        exit;
    }

    $_SESSION['signup_errors'] = $errors;
    $_SESSION['signup_old'] = [
        'full_name' => $fullName,
        'email' => $email,
        'username' => $username,
        'phone' => $phone,
    ];
    $_SESSION['toast_message'] = 'Please fix the errors in the sign up form';
    $_SESSION['toast_type'] = 'warning';
    header('Location: index.php?page=signup');
    exit;
}

// Handle Profile Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'account' && isset($_GET['action']) && $_GET['action'] === 'update_profile') {
    if (!auth_is_authenticated()) {
        header('Location: index.php?page=login');
        exit;
    }

    $currentUser = auth_current_user();
    $userId = $currentUser['id']; // Ensure this is available from auth_current_user

    $data = [
        'full_name' => trim($_POST['full_name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'username' => trim($_POST['username'] ?? ''),
        'phone' => trim($_POST['phone'] ?? '')
    ];

    $errors = [];
    if (auth_update_user($userId, $data, $errors)) {
        $_SESSION['toast_message'] = 'Profile updated successfully';
        $_SESSION['toast_type'] = 'success';
        header('Location: index.php?page=account');
        exit;
    } else {
        $_SESSION['update_errors'] = $errors;
        $_SESSION['toast_message'] = $errors['general'] ?? 'Please fix the errors';
        $_SESSION['toast_type'] = 'warning';
        header('Location: index.php?page=account'); // Stay on account page to show errors
        exit;
    }
}

// Logout action
if ($page === 'account' && isset($_GET['action']) && $_GET['action'] === 'logout') {
    auth_logout_user();
    $_SESSION['toast_message'] = 'Logged out successfully';
    $_SESSION['toast_type'] = 'success';
    header('Location: index.php');
    exit;
}

// Protect My Account page
if ($page === 'account' && !auth_is_authenticated()) {
    $_SESSION['toast_message'] = 'Please login to access your account';
    $_SESSION['toast_type'] = 'warning';
    header('Location: index.php?page=login');
    exit;
}

// Handle Template Details actions (Buy Now / Add to Cart) before any output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $page === 'template_details') {
    $templateId = $_GET['id'] ?? '';

    if ($templateId) {
        if (isset($_POST['add_to_cart'])) {
            addToCart($templateId);
            header("Location: index.php?page=template_details&id=" . urlencode($templateId) . "&added=1");
            exit;
        }

        if (isset($_POST['buy_now'])) {
            addToCart($templateId);
            header("Location: index.php?page=cart&added=1");
            exit;
        }
    }
}

switch ($page) {
    case 'services':
        $title = "Our Services - DivineSyncServe";
        break;
    case 'templates':
        $title = "Browse Templates - DivineSyncServe";
        break;
    case 'template_details':
        $title = "Template Details - DivineSyncServe";
        break;
    case 'cart':
        $title = "Your Cart - DivineSyncServe";
        break;
    case 'about':
        $title = "About Us - DivineSyncServe";
        break;
    case 'contact':
        $title = "Contact Us - DivineSyncServe";
        break;
    case 'terms':
        $title = "Terms of Service - DivineSyncServe";
        break;
    case 'privacy':
        $title = "Privacy Policy - DivineSyncServe";
        break;
    case 'refund':
        $title = "Refund Policy - DivineSyncServe";
        break;
    case 'login':
        $title = "Login - DivineSyncServe";
        break;
    case 'signup':
        $title = "Create Account - DivineSyncServe";
        break;
    case 'account':
        $title = "My Account - DivineSyncServe";
        break;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="assets/css/style.css?v=<?php echo filemtime('assets/css/style.css'); ?>">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <?php
        switch ($page) {
            case 'services':
                include 'pages/services.php';
                break;
            case 'about':
                include 'pages/about.php';
                break;
            case 'contact':
                include 'pages/contact.php';
                break;
            case 'templates':
                include 'pages/templates.php';
                break;
            case 'template_details':
                include 'pages/template_details.php';
                break;
            case 'cart':
                include 'pages/cart.php';
                break;
            case 'terms':
                include 'pages/terms.php';
                break;
            case 'privacy':
                include 'pages/privacy.php';
                break;
            case 'refund':
                include 'pages/refund.php';
                break;
            case 'login':
                include 'pages/login.php';
                break;
            case 'signup':
                include 'pages/signup.php';
                break;
            case 'account':
                include 'pages/account.php';
                break;
            default:
                include 'pages/home.php';
                break;
        }
        ?>
    </main>

    <?php include 'includes/footer.php'; ?>

    <?php if (!empty($_SESSION['toast_message'])): ?>
        <script>
            window.addEventListener('DOMContentLoaded', function () {
                if (typeof showToast === 'function') {
                    showToast('<?php echo addslashes($_SESSION['toast_message']); ?>', '<?php echo $_SESSION['toast_type'] ?? 'info'; ?>');
                }
            });
        </script>
        <?php
        unset($_SESSION['toast_message'], $_SESSION['toast_type']);
        ?>
    <?php endif; ?>

    <script src="assets/js/main.js"></script>
</body>

</html>